<?php

namespace App\Models;

use CodeIgniter\Model;

class userkuModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'email',
        'username',
        'password_hash',
        'nip',
        'wilayah',
        'image_user',
        'active',
        'created_at',
        'updated_at',
    ];

    public function getUser1($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }
}
