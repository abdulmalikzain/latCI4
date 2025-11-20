<?php

namespace App\Controllers;

use App\Models\RegisterModel;
use CodeIgniter\Controller;
use Dom\Comment;
use Faker\Provider\Base;

class Admin extends BaseController
{
    protected $helpers = ['url', 'form'];

    public function index()
    {
        return view('admin/register_view');
    }

    public function save()
    {
        $validationRules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah digunakan.'
                ]
            ],
            'username' => [
                'rules' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'is_unique' => 'Username sudah digunakan.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'group' => [
                'rules' => 'required|in_list[admin,user]',
                'errors' => [
                    'required' => 'Grup wajib dipilih.',
                    'in_list' => 'Grup tidak valid.'
                ]
            ]
        ];

        if (! $this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $users = new RegisterModel();

        $data = [
            'email'         => $this->request->getPost('email'),
            'username'      => $this->request->getPost('username'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'active'        => 1,
        ];

        // Simpan user baru
        $users->insert($data);
        $userId = $users->getInsertID();

        // Tambahkan user ke grup yang dipilih
        $auth = service('authorization');
        $auth->addUserToGroup($userId, $this->request->getPost('group'));

        return redirect()->to('admin/tambahuser')->with('success', 'User berhasil ditambahkan ke grup ' . $this->request->getPost('group'));
    }

    public function listuser()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $builder->select('users.id as userid, username, email, name');
        $builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $query = $builder->get();

        $data['users'] = $query->getResult();

        return view('admin/listUser', $data);
    }
}
