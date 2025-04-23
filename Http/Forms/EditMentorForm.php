<?php

namespace Http\Forms;

use Core\Validator;

class EditMentorForm extends FormValidation
{
    public function validate(array $attributes)
    {
        if (!Validator::email($attributes['email'])) {
            $this->errors['mentor'] = 'Should be a valid email address';
        }
    }
}