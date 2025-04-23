<?php

namespace Http\Forms;

use Core\Validator;

class MeetingCreateForm extends FormValidation
{
    public function validate(array $attributes)
    {
        if (!Validator::string($attributes['body'], 1, 1000)) {
            $this->errors['body'] = 'A body of no more than 1,000 characters is required.';
        }
        if (!Validator::string($attributes['topic'], 1, 50)) {
            $this->errors['topic'] = 'A topic of no more than 1,000 characters is required.';
        }
        if (empty($attributes['date'])) {
            $this->errors['meeting_datetime'] = 'Please select a meeting date.';
        }
    }
}