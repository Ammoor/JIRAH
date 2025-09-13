<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $userData)
    {
        return User::create($userData)->fresh();
    }
}
