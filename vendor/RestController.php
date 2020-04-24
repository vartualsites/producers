<?php

namespace Isystems\Vendor;

use Infrastructure\Database;

abstract class RestController implements RestInterface {
    protected $endpoint = ''; // string
    private $method = 'get'; // string
    private $params = ''; // string|integer
    private $inputs = array(); // array
    private $controller = ''; // string
    private $function = 'getAll'; // string
    private $rawResponse = null;
    private $response = null;
    private $responseHeaders = ''; // string
    private $errors = array();
    private $isklep = null; // RestIsklep object

    public function __construct() {
        $this->processRoute();

        if($this->endpoint === '')
            $this->setEndpoint();

        $this->setMethod();

        if(!$this->executeMethod()) {
            Output::setCode(404);
            $view = new View();
            $view->renderTemplate('notFound.php');
        }

    }

    public static function getDb()
    {
        return Database::mysqli();
    }

    public function sendRequest() {
        $this->isklep = new RestIsklep();

        switch($this->method) {
            case 'get':
                break;
            case 'getAll':
                $this->isklep->getAll($this->endpoint);
                break;
            case 'post':
                $this->isklep->post($this->endpoint, $this->inputs);
                break;
            case 'put':
                break;
        }
    }

    public function getErrors() {
        $return = '';
        if(!empty($this->errors)) {
            foreach ($this->errors as $error)
                $return .= $error . "<br />";
        }

        return $return;
    }

    public function setError($message = '', $code = '') {
        $this->errors[] = 'Błąd '.$code.' - '.$message.'<br/>';
    }

    public function getResults($array = false) {
        $this->rawResponse = $this->isklep->getResults();
        $this->prepareResponse();
        $results = json_decode($this->response, $array);
        return $results;
    }

    protected function setMethod() {
        $method = strtolower($_SERVER['REQUEST_METHOD']);

        if($method === 'get') {
            $this->method = $this->params ? $method : 'getAll';
        } else {
            $this->method = $method;
        }
    }

    protected function setPostInputs($inputs = array()) {
        $this->inputs = $inputs;
    }

    private function setEndpoint() {
        $controller = $this->controller;
        if(strncmp('/', $controller, 1) != 0)
            $controller = '/'.$controller;

        $this->endpoint = $controller;
    }

    private function processRoute() {
        $requestEndpoints = Input::getRequestEndpoints();
        $this->controller = $requestEndpoints->class;
        $functions = array('' => 'getAll', 'index' => 'getAll', 'add' => 'post', 'get' => 'get');
        $this->function = isset($functions[$requestEndpoints->method]) ? $functions[$requestEndpoints->method] : 'getAll';
        $this->params = $requestEndpoints->params;
    }

    private function executeMethod() {
        if(!method_exists($this, $this->function))
            return false;

        $this->{$this->function}($this->params);
        return true;
    }

    private function prepareResponse() {
        if(!$this->rawResponse) {
            if(($error = $this->isklep->getErrors()))
                $this->setError($error);

            $this->setError('Nie można połączyć się z systemem.');
            return;
        }
        if(strstr($this->rawResponse, '{')) {
            $headers = substr($this->rawResponse, 0, strpos($this->rawResponse, '{'));
            $content = trim(str_replace($headers, '', $this->rawResponse));
            $this->response = $content;
        } else
            $headers = $this->rawResponse;

        $this->responseHeaders = trim($headers);
        $code = $this->getResponseCode();

        Output::setCode($code);
        $this->setErrorCode($code);
    }

    private function setErrorCode($code) {
        if(strncmp($code, '4', 1) === 0)
            $this->setError('Nie można zrealizować tego żądania bądź znaleźć strony.', $code);
        if(strncmp($code, '5', 1) === 0)
            $this->setError('Wystąpił nieoczekiwany błąd systemu.', $code);
    }

    private function getResponseCode() {
        if(strncmp($this->responseHeaders, 'HTTP/1.1', 8) === 0)
            $withoutHttp = str_replace('HTTP/1.1', '', $this->responseHeaders);

        $withoutHttp = substr($this->responseHeaders, 9);
        $responseCode = substr($withoutHttp, 0, 3);
        return $responseCode;
    }
}