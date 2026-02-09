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

        $startDate = $this->request->getGet('startDate');
        $endDate   = $this->request->getGet('endDate');

        if (!$startDate || !$endDate) {
            $endDate = date('Y-m-d'); // Hari ini
            $startDate = date('Y') . '-01-01'; // 1 Januari tahun ini
        }

        $data['jumlahKotaKecamatan'] = $this->dataWilayahModel->getJumlahByKabupatenKecamatan($startDate, $endDate);
        $data['startDate'] = $startDate;
        $data['endDate']   = $endDate;

        return view('user/index', $data);
    }

    public function getData()
    {
        $startDate = $this->request->getGet('startDate');
        $endDate   = $this->request->getGet('endDate');

        $data1 = $this->dataWilayahModel
            ->getJumlahByKabupatenKecamatan($startDate, $endDate);

        // return JSON (jangan view)
        return $this->response->setJSON($data1);
    }
}
