<?php

namespace Isystems\Vendor;

interface RestInterface {
    public function sendRequest();
    public function getResults();
    public function getAll();
    public function get();
    public function post();
    public function put();
    public function delete();
    public function getErrors();
    public function setError($message = '', $code = '');
}