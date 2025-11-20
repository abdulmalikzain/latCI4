<?php


namespace App\Controllers;

use App\Models\DataWilayahModel;
use CodeIgniter\CLI\Console;
use Symfony\Contracts\Service\Attribute\Required;

use Myth\Auth\Config\Auth as AuthConfig;

class User extends BaseController
{
    protected $dataWilayahModel;

    public function __construct()
    {
        $this->dataWilayahModel = new DataWilayahModel();;
    }

    public function index()
    {

        $tanggal = $this->request->getGet('tanggal') ?? date('Y-m-d');

        $data['jumlahKotaKecamatan'] = $this->dataWilayahModel->getJumlahByKabupatenKecamatan($tanggal);
        $data['tanggal'] = $tanggal; // ← kirim ke view

        return view('user/index', $data);
    }

    public function getData()
    {
        $tanggal = $this->request->getGet('tanggal');

        $data1 = $this->dataWilayahModel->getJumlahByKabupatenKecamatan($tanggal);

        // return JSON (jangan view)
        return $this->response->setJSON($data1);
    }
}
