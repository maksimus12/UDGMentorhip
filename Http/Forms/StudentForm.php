<?php

namespace Http\Forms;

use Core\Validator;

class StudentForm extends FormValidation
{
    public function validate(array $attributes): void
    {
        if (!Validator::string($attributes['student_name'], 1, 50)) {
            $this->errors['student_name'] = 'A Name should be no more than 50 characters is required.';
        }

        if (empty($attributes['mentor'])) {
            $this->errors['mentor'] = 'Mentor is required.';
        }
    }
}
