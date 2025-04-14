<?php

namespace Http\Models;

use Core\BasicModel;

class UserModel extends BasicModel
{
    public function getAll()
    {
        return $this->db->query('SELECT * FROM users')->get();
    }
}
