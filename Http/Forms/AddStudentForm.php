<?php

namespace Http\Forms;

use Core\Validator;

class AddStudentForm extends FormValidation
{
    public function validate($attributes): void
    {
        if (!Validator::string($attributes['student_name'], 1, 50)) {
            $this->errors['student_name'] = 'A Name should be no more than 50 characters is required.';
        }

        if (empty($attributes['mentor'])) {
            $this->errors['mentor'] = 'Mentor is required.';
        }
    }
}
