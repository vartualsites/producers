<?php

namespace Isystems\Vendor;

class RestIsklep implements RestInterface {

    private $httpClientHandler = null; // CurlHttpClient object
    private $errors = array(); // array
    private $rawResponse = null;

    public function __construct() {
        $this->httpClientHandler = HttpClient::detectHttpClientHandler();
    }

    public function sendRequest($endpoint = '', $method = 'get', $headers = array(), $inputs = array(), $curlOptions = array()) {
        if(!$this->checkHttpToolAvailability())
            return false;

        $this->httpClientHandler->init($endpoint);

        if(!empty($curlOptions)) {
            foreach($curlOptions as $option => $value)
                $this->httpClientHandler->addOption($option, $value);
        }

        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: pl';
        // give permission for call to external sources
        $headers[] = 'Access-Control-Allow-Origin';

        $this->httpClientHandler->addOption(CURLOPT_HEADER, true);
        $this->httpClientHandler->addOption(CURLOPT_HTTPHEADER, $headers);
        $this->httpClientHandler->addOption(CURLOPT_SSL_VERIFYPEER, false);
        $this->httpClientHandler->setOptArray();

        $this->rawResponse = $this->httpClientHandler->exec();
        //die(var_dump($this->rawResponse));
        $this->httpClientHandler->close();
    }

    public function getResults() {
        return $this->rawResponse;
    }

    public function get() { }

    public function getAll($endpoint = '') {
        $this->sendRequest($endpoint, 'get');
    }

    public function post($endpoint = '', $inputs = array()) {
        $headers = array('Content-Type: application/json');
        $params = json_encode($inputs);
        $curlOptions = array(CURLOPT_POST => true, CURLOPT_POSTFIELDS => $params);
        $this->sendRequest($endpoint, 'post', $headers, $inputs, $curlOptions);
    }

    public function put() {}

    public function delete() {}

    public function getErrors() {
        $return = '';
        if(!empty($this->errors)) {
            foreach ($this->errors as $error)
                $return .= $error . "<br />";
        }

        return $return;
    }

    public function setError($message = '', $code = '') {
        $this->errors[] = 'Error: '.$code.' - '.$message.'<br/>';
    }

    private function checkHttpToolAvailability() {
        if($this->httpClientHandler instanceof CurlHttpClient)
            return true;

        $this->setError('Nie można wykorzystać narzędzia Curl.', 41);
        return false;
    }
}