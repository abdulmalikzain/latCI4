<?php

namespace App\Controllers;

use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Authentication\Authenticators\Session;
use App\Models\DataWilayahModel;
use CodeIgniter\CLI\Console;
use Symfony\Contracts\Service\Attribute\Required;

class Home extends BaseController
{
    protected $dataWilayahModel;
    protected $auth;

    public function __construct()
    {
        $this->dataWilayahModel = new DataWilayahModel();
        $this->auth = service('authentication');
    }

    public function index()
    {
        // $config = config(AuthConfig::class); // Ambil config Auth
        // return view('auth/login', ['config' => $config]); // Kirim ke view
        // return view('auth/login');
        if ($this->auth->check()) {
            return redirect()->to(site_url('user'));
        }

        $config = config(AuthConfig::class); // Ambil config Auth
        return view('auth/login', ['config' => $config]); // Kirim ke view
    }

    public function register()
    {
        return view('auth/register'); // Kirim ke view
    }

    public function map()
    {
        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        $data['jumlahKotaKecamatan'] = $this->dataWilayahModel->getJumlahByKabupatenKecamatan($tanggal);
        $data['tanggal'] = $tanggal; // ← kirim ke view
        return view('v_homeMap', $data);
    }

    public function getData()
    {
        $tanggal = $this->request->getGet('tanggal');

        $data1 = $this->dataWilayahModel->getJumlahByKabupatenKecamatan($tanggal);

        // return JSON (jangan view)
        return $this->response->setJSON($data1);
    }

    public function testpass()
    {
        return view('testpassword'); // Kirim ke view
    }
}
