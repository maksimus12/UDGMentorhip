<?php

namespace Core;

abstract class BasicModel
{
    public function __construct(
        protected Database $db,
    ) {
        $this->db = App::resolve(Database::class);
    }
}
