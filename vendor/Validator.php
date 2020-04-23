<?php

namespace Isystems\Vendor;

class Validator {
    private $values = array(); // array
    private $rules = array(); // array
    private $errors = array(); // array

    /**
     * Set rules for some fields
     *
     * @param array $rules array('name' => array('rules' => array('function1', 'function2')))
     * @return void
     */
    public function setRules($rules = array()) {
        if(!empty($rules))
            $this->rules = $rules;
    }

    public function run() {
        $this->values = $_POST;
        if(empty($this->values))
            return false;

        if(empty($this->rules))
            return false;

        // array('name' => array('rules' => array('funckcja1'));
        foreach($this->values as $fieldName => $value) {
            $rules = $this->rules[$fieldName]['rules'];
            if(empty($rules))
                continue;

            if(!in_array('required', $rules) && trim($value) === '') {
                $this->values[$fieldName] = null;
                continue;
            }

            foreach($rules as $rule) {
                if(method_exists($this, $rule)) {
                    if(!$this->values[$fieldName] = $this->{$rule}($fieldName, $value))
                        break;
                } else {
                    if(function_exists($rule))
                        $this->values[$fieldName] = $rule($value);
                }
            }
        }

        if(!empty($this->errors))
            return false;

        return true;
    }

    public function getErrors() {
        if(!empty($this->errors)) {
            return $this->errors;
        }
    }

    public function getValues($fieldName = null) {
        if($fieldName && isset($this->values[$fieldName]))
            return $this->values[$fieldName];

        return $this->values;
    }

    private function required($fieldName, $value) {
        if(trim($value) == '') {
            $this->errors[$fieldName] = 'Proszę podać nazwę użytkownika.';
            return false;
        }
        return $value;
    }

    private function integer($fieldName, $value) {
        if(!preg_match('/^[0-9]+$/', $value)) {
            $this->errors[$fieldName] = 'Proszę podać liczbę całkowitą.';
            return false;
        }
        return $value;
    }

    private function xssClean($fieldName, $value) {
        return rawurldecode(strip_tags(str_replace(array(PHP_EOL, '<', '/>', '>', '<?', '<?php', '?>'), ' ', $value)));
    }

    private function imageFileName($fielName, $value) {
        $explode = explode('.', $value);

        if(count($explode) > 1) {
            if(!empty($explode[0])) {
                if(in_array(end($explode), array('png', 'jpeg', 'jpg', 'gif', 'svg')))
                    return $value;
            }
        }
        $this->errors[$fielName] = 'Proszę podać poprawną nazwę pliku wraz z rozszerzeniem.';
        return false;
    }

    private function prepUrl($fieldName, $value) {
        if($value === 'http://') {
            $this->errors[$fieldName] = 'Proszę wprowadzić poprawny adres WWW';
            return false;
        }

        $parse = parse_url($value);

        if(!$parse){
            $this->errors[$fieldName] = 'Proszę wprowadzić poprawny adres WWW';
            return false;
        }
        if(!isset($parse['scheme']))
            $value = 'http://'.$value;

        return $value;
    }


}