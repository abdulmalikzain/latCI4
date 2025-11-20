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
            "Semarang",
            "Sragen",
            "Sukoharjo",
            "Tegal",
            "Temanggung",
            "Wonogiri",
            "Wonosobo",
            "Kota Magelang",
            "Kota Pekalongan",
            "Kota Salatiga",
            "Kota Semarang",
            "Kota Surakarta",
            "Kota Tegal"
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
        // validasi kolom
        if (! $this->validate([
            'tglKejadian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal Kejadian harus diisi'
                ]
            ],
            'waktuKejadian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'waktu Kejadian harus diisi'
                ]
            ],
            'kabKota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kabupaten/Kota harus diisi'
                ]
            ],
            'kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kecamatan harus diisi'
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            $data['validation'] = $validation;
            // return view('dataKebakaran/inputData', $data);
            return redirect()->back()->withInput()->with('validation', $validation);

            // return redirect()->to('/inputData')->withInput()->with('validation', $validation);
        }

        ///simpan
        $this->dataWilayahModel->save([
            'tglKejadian' => $this->request->getVar('tglKejadian'),
            'waktuKejadian' => $this->request->getVar('waktuKejadian'),
            'kabKota' => $this->request->getVar('kabKota'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'jenisObjek' => $this->request->getVar('jenisObjek'),
            'penyebab' => $this->request->getVar('penyebab'),
            'jmlBangunan' => $this->request->getVar('jmlBangunan'),
            'korbanMeninggal' => $this->request->getVar('korbanMeninggal'),
            'korbanLuka' => $this->request->getVar('korbanLuka'),
            'kerugian' => $this->request->getVar('kerugian'),
            'waktuRespon' => $this->request->getVar('waktuRespon'),
            'jmlArmada' => $this->request->getVar('jmlArmada'),
            'jmlPersonil' => $this->request->getVar('jmlPersonil'),
            'sumberInfo' => $this->request->getVar('sumberInfo')
        ]);

        session()->setFlashdata('pesan', 'Data berhasil ditambahkan.');
        return redirect()->to('data/tampilData');
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
        $data['datakebakaran'] = $builder->limit($perPage, $offset)->get()->getResultArray();

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
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('data/tampilData');
    }

    public function editData($id)
    {
        // session();
        $data = [
            'validation' => \Config\Services::validation(),
            'wilayah' => $this->dataWilayahModel->getWilayah($id)
        ];

        return view('dataKebakaran/editData', $data);
    }

    public function updateData($id)
    {
        // validasi kolom
        if (! $this->validate([
            'tglKejadian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'tanggal Kejadian harus diisi'
                ]
            ],
            'waktuKejadian' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'waktu Kejadian harus diisi'
                ]
            ],
            'kabKota' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kabupaten/Kota harus diisi'
                ]
            ],
            'kecamatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'kecamatan harus diisi'
                ]
            ],
        ])) {
            $validation = \Config\Services::validation();
            $data['validation'] = $validation;
            // return view('editData/' . $this->request->getVar('id'), $data);
            // return redirect()->to('editData/' . $this->request->getVar('id'))->withInput()->with('validation', $validation);
            return redirect()->back()->withInput()->with('validation', $validation);
        }

        $this->dataWilayahModel->save([
            'id' => $id,
            'tglKejadian' => $this->request->getVar('tglKejadian'),
            'waktuKejadian' => $this->request->getVar('waktuKejadian'),
            'kabKota' => $this->request->getVar('kabKota'),
            'kecamatan' => $this->request->getVar('kecamatan'),
            'jenisObjek' => $this->request->getVar('jenisObjek'),
            'penyebab' => $this->request->getVar('penyebab'),
            'jmlBangunan' => $this->request->getVar('jmlBangunan'),
            'korbanMeninggal' => $this->request->getVar('korbanMeninggal'),
            'korbanLuka' => $this->request->getVar('korbanLuka'),
            'kerugian' => $this->request->getVar('kerugian'),
            'waktuRespon' => $this->request->getVar('waktuRespon'),
            'jmlArmada' => $this->request->getVar('jmlArmada'),
            'jmlPersonil' => $this->request->getVar('jmlPersonil'),
            'sumberInfo' => $this->request->getVar('sumberInfo')

        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to('data/tampilData');
        // dd($this->request->getVar());
    }
}
