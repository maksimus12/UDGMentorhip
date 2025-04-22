<?php

namespace Http\Forms;
use Core\Validator;

class EditStudentForm extends FormValidation
{
    public function validate(array $attributes): void
    {
        if (!Validator::string($attributes['student_name'], 1, 50)) {
            $this->errors['student_name'] = 'A Name of no more than 50 and no less then 1 characters is required.';
        }
    }
}