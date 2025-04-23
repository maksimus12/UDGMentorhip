<?php

namespace Http\Forms;

use Core\Validator;

class RegistrationForm extends FormValidation
{
    public function validate($attributes)
    {
        if (!Validator::email($attributes['email'])) {
            $this->errors['email'] = 'Provide a valid email';
        }

        if (!Validator::string($attributes['password'], 7, 255)) {
            $this->errors['password'] = 'Provide a valid password';
        }

        if ($attributes['user']) {
            $this->errors['email'] = 'This email is already taken';
        }
    }
}