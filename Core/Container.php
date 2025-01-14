<?php

namespace Core;


class Container
{

    protected $bindings = [];

    public function bind($key, $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve($key)
    {
        if (!array_key_exists($key, $this->bindings)) {
            return new \Exception("No matching binding for {$key}");
        }
        $resolver = $this->bindings[$key];

        return call_user_func($resolver);
    }

}