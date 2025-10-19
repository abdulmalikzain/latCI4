<?php

namespace App\Controllers;

use Myth\Auth\Config\Auth as AuthConfig;

use App\Models\DataWilayahModel;
use CodeIgniter\CLI\Console;
use Symfony\Contracts\Service\Attribute\Required;

class Home extends BaseController
{
    protected $dataWilayahModel;

    public function __construct()
    {
        $this->dataWilayahModel = new DataWilayahModel();;
    }

    public function index(): string
    {
        // $config = config(AuthConfig::class); // Ambil config Auth
        // return view('auth/login', ['config' => $config]); // Kirim ke view
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function map(): string
    {
        $dataKec = new DataWilayahModel();
        // Ambil data jumlah berdasarkan 
        $dataKecamatan = $dataKec->getJumlahByKecamatan();

        return view('v_homeMap', ['data' => $dataKecamatan]);
    }
}
