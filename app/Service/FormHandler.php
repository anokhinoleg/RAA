<?php

namespace Service;

class FormHandler
{
    private $errors;

    private $data;

    public function __construct(Request $requestedArray)
    {
        $this->data = $requestedArray;
    }

    private function passwordLength($pass) {
        if (strlen($pass) < 8) {
            $this->errors['short_password'] = "password should not be shorter than 8 characters" ;
        }
    }

    private function isValidEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors['incorrect_email'] = "incorrect email";
        }
    }

    private function validateFields($requiredFields) {
        if (key_exists('submit', $requiredFields)) {
            unset($requiredFields['submit']);
        }
        foreach ($requiredFields as $field => $value) {
            if ($value == "") {
                if ($field != 'country_id') {
                    $this->errors[$field] = str_replace("_", " ", $field) . " can't be blank";
                } else {
                    $this->errors[$field] = "country name can't be blank";
                }
                if (!isset($requiredFields['condition'])) {
                    $this->errors['condition'] = "you can not register without accepting conditions";
                }
            }
            if ($field == 'email' && $value != "") {
                $this->isValidEmail($value);
            }
            if ($field == 'password' && $value != "") {
                $this->passwordLength($value);
            }
        }
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        $this->validateFields($this->data->getRequestedArray());
        if (!empty($this->errors)) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function isSubmitted()
    {
        if (key_exists('submit', $this->data->getRequestedArray())) {
            return true;
        }
        return false;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getData()
    {
        $data = $this->data->getRequestedArray();

        if (key_exists('submit', $data) || key_exists('condition' , $data)) {
            unset($data['submit']);
            unset($data['condition']);
        }
        return $data;
    }
}