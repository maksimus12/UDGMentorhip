<?php

namespace Http\Forms;
use Core\ValidationException;
abstract class FormValidation
{
    protected $errors = [];
    abstract public function validate();

    public function getErrors(){
        return $this->errors;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

}