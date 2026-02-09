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

        // Ambil request GET jika ada
        $startDate = $this->request->getGet('startDate');
        $endDate   = $this->request->getGet('endDate');

        if (!$startDate || !$endDate) {
            $endDate = date('Y-m-d'); // Hari ini
            $startDate = date('Y') . '-01-01'; // 1 Januari tahun ini
        }

        $data['jumlahKotaKecamatan'] = $this->dataWilayahModel->getJumlahByKabupatenKecamatan($startDate, $endDate);
        $data['startDate'] = $startDate;
        $data['endDate']   = $endDate;

        return view('v_homeMap', $data);
    }

    public function getData()
    {
        $startDate = $this->request->getGet('startDate');
        $endDate   = $this->request->getGet('endDate');

        $data1 = $this->dataWilayahModel
            ->getJumlahByKabupatenKecamatan($startDate, $endDate);

        return $this->response->setJSON($data1);
    }

    public function testpass()
    {
        return view('testpassword'); // Kirim ke view
    }
}
