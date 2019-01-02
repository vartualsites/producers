<?php

namespace Isystems\Vendor;

use Isystems\Config\Auth;

class CurlHttpClient implements HttpClientInterface {

    private $ch;
    private $options = array();
    private $url = '';
    private $authorizationData = '';
    private $returnResponseToVariable = true;

    public function __construct() {
        $config = Auth::getCredentials();

        if(isset($config) && !empty($config)) {
            foreach($config as $field => $value)
                $this->{$field} = $value;
        }
    }

    public function init($endpoint = '') {
        $this->ch = curl_init($this->url.$endpoint);
    }

    public function addOption($optKey = '', $optValue = '') {
        $this->options[$optKey] = $optValue;
    }

    public function setOpt($optKey = '', $optValue = '') {
        curl_setopt($this->ch, $optKey, $optValue);
    }

    public function setOptArray() {
        $this->setBasicAuthOptions();
        if($this->returnResponseToVariable)
            $this->options[CURLOPT_RETURNTRANSFER] = true;

        curl_setopt_array($this->ch, $this->options);
    }

    public function exec() {
        return curl_exec($this->ch);
    }

    public function close() {
        curl_close($this->ch);
    }

    private function setBasicAuthOptions() {
        $this->options[CURLOPT_HTTPAUTH] = CURLAUTH_BASIC;
        $this->options[CURLOPT_USERPWD] = $this->authorizationData;
    }

}