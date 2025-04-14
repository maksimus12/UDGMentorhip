<?php

namespace Http\Forms;

use Core\Validator;
use Core\ValidationException;

class AddStudentForm
{
    protected $errors = [];

    public function __construct(public array $attributes)
    {
        if (!Validator::string($attributes['student_name'], 1, 50)) {
            $this->errors['student_name'] = 'A Name should be no more than 50 characters is required.';
        }

        if (empty($attributes['mentor'])) {
            $this->errors['mentor'] = 'Mentor is required.';
        }

    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }
    public function failed()
    {
        return count($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($field, $message)
    {
        $this->errors[$field] = $message;
        return $this;
    }

}