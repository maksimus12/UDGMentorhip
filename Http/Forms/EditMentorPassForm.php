<?php

namespace Http\Forms;

use Core\Validator;

class EditMentorPassForm extends FormValidation
{
    public function validate($attributes)
    {
        if (!Validator::string($attributes['pass'])) {
            $this->errors['pass'] = 'Should be a valid password';
        }
        if (empty($attributes['id'])) {
            $this->errors['id'] = 'Should have a valid id';
        }
    }
}
