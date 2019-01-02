<?php

namespace Isystems\Controllers;

use Isystems\Vendor\RestController;
use Isystems\Vendor\View;
use Isystems\Vendor\Validator;
use Isystems\Vendor\Errors;

class Producers extends RestController {

    protected $endpoint = '/producers';

    public function getAll() {
//        $this->sendRequest();
        $results = null;// $this->getResults();
        $rows = $errors = array();
        $success = false;

        if($results === null) {
            $errors['apiErrors'] = $this->getErrors();
        } else {
            $success = $results->success;
            if($results->success === true) {
                $rows = (array) $results->data->producers;
                krsort($rows);
                $rows = (object) $rows;
            } else {
                $errors['apiErrors'] = Errors::getErrorMessage($results->error->reason_code);
            }
        }
        $view = new View();
        // hardcode list
        if (empty($rows)) {
            $rows = self::getDb()->getProducers();
        }
        $view->renderTemplate('list.php', array('rows' => $rows, 'errors' => $errors, 'success' => $success));
    }

    public function get($id = null) {}
    
    public function post() {
        require_once 'vendor/Validator.php';
        $validator = new Validator();
        $validator->setRules(array(
            'name' => array('rules' => array('required', 'trim', 'xssClean')),
            'site_url' => array('rules' => array('prepUrl', 'trim')),
            'logo_filename' => array('rules' => array('imageFileName', 'trim', 'xssClean')),
            'ordering' => array('rules' => array('required', 'trim', 'integer', 'xssClean')),
            'source_id' => array('rules' => array('trim', 'xssClean')),
        ));

        $errors = $fields = array();
        $success = false;

        if($validator->run()) {
            $inputs = $validator->getValues();
//            $this->setPostInputs($inputs);
//            $this->sendRequest();
//            $results = null;//$this->getResults();
//            if($results === null) {
//                $errors['apiErrors'] = $this->getErrors();
//            } else {
//                $success = $results->success;
//                //$errors['apiErrors'] = $this->getErrors();
//                $errors['apiErrors'] = Errors::getErrorMessage($results->error->reason_code);
//            }
            $db = self::getDb();
            $db->postProducer($inputs);

            if ($db->insertedId() > 0) {
                $success = true;
            } else {
                $errors['apiErrors'] = 'Nie udało się dodać producenta.';
            }
        } else {
            $errors = $validator->getErrors();
            $fields = $validator->getValues();
        }

        //global $view;
        $view = new View();
        $view->renderTemplate('form.php', array('errors' => $errors, 'fields' => $fields, 'success' => $success));
    }

    public function put() {}

    public function delete() {}
}