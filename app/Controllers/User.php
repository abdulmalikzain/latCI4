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

    public function index(): string
    {
        $dataKec = new DataWilayahModel();
        // Ambil data jumlah berdasarkan 
        $dataKecamatan = $dataKec->getJumlahByKecamatan();

        // $config = new AuthConfig();

        return view('user/index', ['data' => $dataKecamatan]);
    }

    // public function index(): string
    // {
    //     // $dataKec = new DataWilayahModel();
    //     // // Ambil data jumlah berdasarkan 
    //     // $dataKecamatan = $dataKec->getJumlahByKecamatan();


    //     return view('user/index');
    // }
}
