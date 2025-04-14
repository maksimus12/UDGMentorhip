<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm extends FormValidation
{
    public function validate($attributes): void
    {
        if (!Validator::email($attributes['email'])) {
            $this->errors['email'] = 'Provide a valid email';
        }

        if (!Validator::string($attributes['password'])) {
            $this->errors['password'] = 'Provide a valid password';
        }
    }
}
