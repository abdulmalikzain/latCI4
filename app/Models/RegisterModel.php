<?php

namespace App\Models;

use Myth\Auth\Models\UserModel;

class RegisterModel extends UserModel
{
    protected $allowedFields = [
        'email',
        'username',
        'password_hash',
        'active',
    ];
}
