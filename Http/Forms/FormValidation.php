<?php

namespace Http\Forms;

use Core\ValidationException;

abstract class FormValidation
{
    protected array $errors = [];
    protected array $attributes = [];

    abstract public function validate(array $attributes);

    public static function make($attributes): static
    {
        $instance = new static();

        $instance->attributes = $attributes;
        $instance->validate($attributes);
        if ($instance->failed()) {
            $instance->throw();
        }
        return $instance;
    }

    /**
     * @throws ValidationException
     */
    public function throw(): void
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }

    public function failed(): int
    {
        return count($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function error($field, $message): static
    {
        $this->errors[$field] = $message;
        return $this;
    }
}
