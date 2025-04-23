<?php

namespace Http\Forms;

use Core\Validator;

class EditMentorForm extends FormValidation
{
    public function validate($attributes)
    {
        if (!Validator::email($attributes['email'])) {
            $this->errors['mentor'] = 'Should be a valid email address';
        }
        if (empty($attributes['id'])) {
            $this->errors['id'] = 'Should have a valid id';
        }
    }
}