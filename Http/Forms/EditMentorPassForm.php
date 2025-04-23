<?php

namespace Http\Forms;

use Core\Validator;

class EditMentorPassForm extends FormValidation
{
    public function validate(array $attributes)
    {
        if (!Validator::string($attributes['pass'])) {
            $this->errors['pass'] = 'Should be a valid password';
        }
    }
}
