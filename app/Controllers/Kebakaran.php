<?php

namespace App\Controllers;

use App\Models\DataWilayahModel;
use CodeIgniter\CLI\Console;
use Symfony\Contracts\Service\Attribute\Required;

class Kebakaran extends BaseController
{
    protected $dataWilayahModel;

    public function __construct()
    {
        $this->dataWilayahModel = new DataWilayahModel();;
    }

    public function index() {}

    public function inputData()
    {
        $user = user();

        // ------------------------------
        // 1. Ambil data user login & group
        // ------------------------------
        $user = user(); // dari Myth/Auth

        $userWilayah = $user->wilayah;
        // Ambil group user
        $groupModel = model('Myth\Auth\Models\GroupModel');
        $groups = $groupModel
            ->select('auth_groups.name')
            ->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id')
            ->where('auth_groups_users.user_id', $user->id)
            ->findAll();

        $isAdmin = in_array('admin', array_column($groups, 'name'));

        // Semua wilayah (list static)
        $listWilayah = [
            "Banjarnegara",
            "Banyumas",
            "Batang",
            "Blora",
            "Boyolali",
            "Brebes",
            "Cilacap",
            "Demak",
            "Grobogan",
            "Jepara",
            "Karanganyar",
            "Kebumen",
            "Kendal",
            "Klaten",
            "Kudus",
            "Magelang",
            "Pati",
            "Pekalongan",
            "Pemalang",
            "Purbalingga",
            "Purworejo",
            "Rembang",
            "Semarang",
            "Sragen",
            "Sukoharjo",
            "Tegal",
            "Temanggung",
            "Wonogiri",
            "Wonosobo",
            "KotaMagelang",
            "KotaPekalongan",
            "KotaSalatiga",
            "KotaSemarang",
            "KotaSurakarta",
            "KotaTegal"
        ];

        // Jika admin → bisa pilih semua wilayah
        if ($isAdmin) {
            $dropdownWilayah = $listWilayah;
        } else {
            // User biasa hanya bisa pilih wilayahnya sendiri
            $dropdownWilayah = [$userWilayah];
        }

        $data = [
            'wilayahList' => $dropdownWilayah,
            'validation' => \Config\Services::validation()
        ];


        return view('dataKebakaran/inputData', $data);
    }

    public function insertData()
    {
        session();
        // VALIDASI WAJIB
        if (! $this->validate([
            'tglKejadian' => 'required|valid_date',
            'waktuKejadian' => 'required',
            'kabKota' => 'required',
            'kecamatan' => 'required',
            'jenisObjek' => 'required',
            'penyebab' => 'required',
            'jmlBangunan' => 'required|numeric',
            'korbanMeninggal' => 'required|numeric',
            'korbanLuka' => 'required|numeric',
            'waktuRespon' => 'required',
            'jmlArmada' => 'required|numeric',
            'jmlPersonil' => 'required|numeric',

        ])) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        // AMBIL DATA
        $tglKejadian  = $this->request->getPost('tglKejadian');
        $waktuKejadian = $this->request->getPost('waktuKejadian');
        $kabKota      = $this->request->getPost('kabKota');
        $kecamatan    = $this->request->getPost('kecamatan');

        // 🔥 CEK DUPLIKAT
        if ($this->dataWilayahModel->cekDuplikat($tglKejadian, $waktuKejadian, $kabKota, $kecamatan)) {

            return redirect()->back()
                ->withInput()
                ->with('warning', 'Data kejadian dengan tanggal, waktu, dan lokasi yang sama sudah ada!');
        }

        //  🔥 CLEAN KERUGIAN (Rp, titik, dll)
        $kerugian = $this->request->getPost('kerugian');
        $kerugianClean = preg_replace('/[^0-9]/', '', $kerugian);

        //fiel tidak ada pengecekan duplicate
        $jenisObjek      = $this->request->getPost('jenisObjek');
        $penyebab        = $this->request->getPost('penyebab');
        $jmlBangunan     = $this->request->getPost('jmlBangunan');
        $korbanMeninggal = $this->request->getPost('korbanMeninggal');
        $korbanLuka      = $this->request->getPost('korbanLuka');
        $waktuRespon     = $this->request->getPost('waktuRespon');
        $jmlArmada       = $this->request->getPost('jmlArmada');
        $jmlPersonil     = $this->request->getPost('jmlPersonil');
        $sumberInfo      = $this->request->getPost('sumberInfo');

        // INSERT DATA (lanjut normal)
        $this->dataWilayahModel->insert([
            'user_id'        => user()->id,
            'tglKejadian'    => $tglKejadian,
            'waktuKejadian'  => $waktuKejadian,
            'kabKota'        => $kabKota,
            'kecamatan'      => $kecamatan,
            'jenisObjek'     => $jenisObjek,
            'penyebab'       => $penyebab,
            'jmlBangunan'    => $jmlBangunan,
            'korbanMeninggal' => $korbanMeninggal,
            'korbanLuka'     => $korbanLuka,
            'kerugian'       => $kerugianClean,
            'waktuRespon'    => $waktuRespon,
            'jmlArmada'      => $jmlArmada,
            'jmlPersonil'    => $jmlPersonil,
            'sumberInfo'     => $sumberInfo,

            // field lain tetap
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');

        return redirect()->to('data/tampilData')
            ->with('pesan', 'Data berhasil disimpan');
    }

    public function tampilData()
    {
        $kabKota = $this->request->getGet('kabKota');
        $startDate = $this->request->getGet('startDate');
        $endDate = $this->request->getGet('endDate');

        // ------------------------------
        // 1. Ambil data user login & group
        // ------------------------------
        $user = user(); // dari Myth/Auth

        // Ambil group user
        $groupModel = model('Myth\Auth\Models\GroupModel');
        $groups = $groupModel
            ->select('auth_groups.name')
            ->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id')
            ->where('auth_groups_users.user_id', $user->id)
            ->findAll();

        $isAdmin = in_array('admin', array_column($groups, 'name'));

        // Ambil wilayah user (misal: "Cilacap")
        $wilayahUser = $user->wilayah;

        // ------------------------------
        // 2. Filter kab/kota untuk dropdown
        // ------------------------------
        if ($isAdmin) {
            // Admin lihat semua
            $kabkota_list = $this->dataWilayahModel->getKabKotaList();
        } else {
            // User hanya lihat wilayah sendiri
            $kabkota_list = [
                ['kabKota' => $wilayahUser]
            ];

            // Jika user bukan admin, set filter otomatis ke wilayah user
            if (empty($kabKota)) {
                $kabKota = $wilayahUser;
            }
        }

        // ------------------------------
        // 3. Query data (menggunakan filter final)
        // ------------------------------
        $perPage = 10;
        // $builder = $this->dataWilayahModel->getFilteredData($kabKota, $startDate, $endDate);
        $builder = $this->dataWilayahModel->getFilteredData(
            $kabKota,
            $startDate,
            $endDate,
            $isAdmin,
            $wilayahUser
        );

        $page = (int)($this->request->getGet('page') ?? 1);
        $offset = ($page - 1) * $perPage;

        $total = $builder->countAllResults(false);
        // $data['datakebakaran'] = $builder->limit($perPage, $offset)->get()->getResultArray();
        $builder->orderBy('tglKejadian', 'DESC'); // ⬅️ TAMBAHKAN INI

        $data['datakebakaran'] = $builder
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        $pager = \Config\Services::pager();
        $data['pager'] = $pager->makeLinks($page, $perPage, $total, 'default_full');

        // ------------------------------
        // 4. Kirim ke view
        // ------------------------------
        $data['kabkota_list'] = $kabkota_list;

        $data['filter'] = [
            'kabKota' => $kabKota,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        $data['isAdmin'] = $isAdmin;

        return view('dataKebakaran/tampilData', $data);
    }

    public function detail($id)
    {
        $data = [
            'title' => 'detail data',
            'wilayah' => $this->dataWilayahModel->getWilayah($id)
        ];
        // dd($data);
        return view('dataKebakaran/detailData', $data);
    }

    public function delete($id)
    {
        $this->dataWilayahModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('data/tampilData')->with('pesan', 'Data berhasil dihapus.');
    }

    public function editData($id)
    {

        $data = [
            'validation' => \Config\Services::validation(),
            'wilayah' => $this->dataWilayahModel->getWilayah($id)
        ];

        return view('dataKebakaran/editData', $data);
    }

    public function updateData($id)
    {
        session();
        // VALIDASI WAJIB
        if (! $this->validate([
            'jenisObjek' => 'required',
            'penyebab' => 'required',
            'jmlBangunan' => 'required|numeric',
            'korbanMeninggal' => 'required|numeric',
            'korbanLuka' => 'required|numeric',
            'waktuRespon' => 'required',
            'jmlArmada' => 'required|numeric',
            'jmlPersonil' => 'required|numeric',
            'sumberInfo' => 'required',
            'kerugian' => 'required',

        ])) {
            return redirect()->back()
                ->withInput()
                ->with('validation', $this->validator);
        }

        // AMBIL DATA


        //  🔥 CLEAN KERUGIAN (Rp, titik, dll)
        $kerugian = $this->request->getPost('kerugian');
        $kerugianClean = preg_replace('/[^0-9]/', '', $kerugian);

        //fiel tidak ada pengecekan duplicate
        $jenisObjek      = $this->request->getPost('jenisObjek');
        $penyebab        = $this->request->getPost('penyebab');
        $jmlBangunan     = $this->request->getPost('jmlBangunan');
        $korbanMeninggal = $this->request->getPost('korbanMeninggal');
        $korbanLuka      = $this->request->getPost('korbanLuka');
        $waktuRespon     = $this->request->getPost('waktuRespon');
        $jmlArmada       = $this->request->getPost('jmlArmada');
        $jmlPersonil     = $this->request->getPost('jmlPersonil');
        $sumberInfo      = $this->request->getPost('sumberInfo');

        // INSERT DATA (lanjut normal)
        $this->dataWilayahModel->save([
            'id'             => $id,
            'jenisObjek'     => $jenisObjek,
            'penyebab'       => $penyebab,
            'jmlBangunan'    => $jmlBangunan,
            'korbanMeninggal' => $korbanMeninggal,
            'korbanLuka'     => $korbanLuka,
            'kerugian'       => $kerugianClean,
            'waktuRespon'    => $waktuRespon,
            'jmlArmada'      => $jmlArmada,
            'jmlPersonil'    => $jmlPersonil,
            'sumberInfo'     => $sumberInfo,

        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to('data/tampilData')->with('pesan', 'Data berhasil diubah.');
    }
}
