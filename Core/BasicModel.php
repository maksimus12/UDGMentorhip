<?php

namespace Core;

abstract class BasicModel
{
    protected Database $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }
}
