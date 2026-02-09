<?php

namespace App\Controllers;

use Myth\Auth\Entities\User;
use Myth\Auth\Models\UserModel;
use CodeIgniter\Controller;
use App\Models\userkuModel;
use CodeIgniter\Config\Services;


class Admin extends BaseController
{
    protected $userModel;
    protected $userkumodel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->userkumodel = new userkuModel();
    }

    public function index()
    {
        return view('admin/register_view');
    }

    public function save()
    {
        session(); // Start session
        $validation = \Config\Services::validation();

        if (!$this->validate([
            'email'    => 'required|valid_email|is_unique[users.email]',
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'fullName' => 'required|min_length[6]',
            'password' => 'required|min_length[6]',
            'wilayah'  => 'required',
            'role'     => 'required'
        ])) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $user = new User();
        $user->fill([
            'email'        => $this->request->getPost('email'),
            'username'     => $this->request->getPost('username'),
            'fullName'     => $this->request->getPost('fullName'),
            'password'     => $this->request->getPost('password'),
            'wilayah'      => $this->request->getPost('wilayah'),
            'image_user'   => 'default.svg',
            'active'       => 1 // Tambahkan ini
        ]);

        $this->userModel->save($user);

        // Get last user ID
        $userId = $this->userModel->insertID();

        // Assign group -> misal: group "user"
        $role = $this->request->getPost('role');
        $auth = service('authorization');
        $auth->addUserToGroup($userId, $role);

        session()->setFlashdata('pesan', 'User berhasil ditambahkan.');
        return redirect()->to('admin/tambahuser');
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

    public function detailtuser($id)
    {
        $data = [
            'user' => $this->userkumodel->getUser1($id)
        ];

        return view('admin/detailUser', $data);
    }

    public function getUser($id)
    {
        if (!$this->request->isAJAX()) return;

        $user = $this->userModel->find($id);

        return $this->response->setJSON([
            'id'       => $user->id,
            'username' => $user->username,
            'fullName' => $user->fullName,
            'email'    => $user->email,
            'nip'      => $user->nip,
            'wilayah'  => $user->wilayah,
        ]);
    }

    public function updatePhotoAjax()
    {
        if (!$this->request->isAJAX()) {
            return;
        }

        $id = $this->request->getPost('id');
        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User tidak ditemukan'
            ]);
        }

        $image = $this->request->getFile('image_user');

        if (!$image || !$image->isValid() || $image->hasMoved()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'File tidak valid'
            ]);
        }

        // 🔒 Validasi MIME
        $allowedMime = [
            'image/png',
            'image/jpg',
            'image/jpeg',
            'image/webp'
        ];

        if (!in_array($image->getMimeType(), $allowedMime)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Format gambar tidak didukung'
            ]);
        }

        // 🔒 Validasi ukuran (1 MB)
        // if ($image->getSizeByUnit('kb') > 1024) {
        //     return $this->response->setJSON([
        //         'status' => 'error',
        //         'message' => 'Ukuran gambar maksimal 1 MB'
        //     ]);
        // }

        // 🔥 HAPUS FOTO LAMA
        if ($user->image_user && $user->image_user !== 'default.svg') {
            @unlink(FCPATH . 'uploads/user/' . $user->image_user);
        }

        // 🔥 COMPRESS + RESIZE
        $newName = $image->getRandomName();

        Services::image()
            ->withFile($image)
            ->resize(1000, 1000, true, 'width') // max 1000px
            ->save(FCPATH . 'uploads/user/' . $newName, 90); // quality 90%

        // simpan ke entity
        $user->image_user = $newName;
        $this->userModel->save($user);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'id' => $user->id,
                'image_user' => base_url('uploads/user/' . $newName),
                'image_name' => $newName
            ]
        ]);
    }

    // Realtime validation per-field
    public function validateField()
    {
        if (!$this->request->isAJAX()) return;

        $field = $this->request->getPost('field');
        $value = $this->request->getPost('value');

        $rules = [
            'username' => 'required|min_length[6]',
            'fullName' => 'required|min_length[6]',
            'email'    => 'required|valid_email',
            'nip'      => 'required|numeric|min_length[18]|max_length[18]',
        ];

        if (!isset($rules[$field])) return;

        $validation = \Config\Services::validation();
        $validation->setRules([$field => $rules[$field]]);
        $data = [$field => $value];

        if (!$validation->run($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $validation->getError($field)
            ]);
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    // AJAX update
    public function updateAjax()
    {


        if (!$this->request->isAJAX()) return;

        $rules = [
            'username' => 'required|min_length[3]',
            'fullName' => 'required|min_length[6]',
            'email'    => 'required|valid_email',
            'nip'      => 'required|numeric|min_length[18]|max_length[18]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors()
            ]);
        }

        // 🔥 AMBIL USER SEBAGAI ENTITY
        $user = $this->userModel->find($this->request->getPost('id'));

        $user->username = $this->request->getPost('username');
        $user->fullName = $this->request->getPost('fullName');
        $user->email    = $this->request->getPost('email');
        $user->nip      = $this->request->getPost('nip');

        // 🔥 INI KUNCI MYTH/AUTH
        if ($this->request->getPost('password')) {
            $user->password = $this->request->getPost('password');
            // otomatis → password_hash
        }

        $this->userModel->save($user);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => [
                'username' => $user->username,
                'fullName' => $user->fullName,
                'email'    => $user->email,
                'nip'      => $user->nip,
            ]
        ]);
    }
}
