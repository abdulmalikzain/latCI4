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

    public function index(): string
    {
        return view('dataKebakaran/inputData');
    }

    public function inputData()
    {
        session();
        $data = [
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
        $dataWilayah = $this->dataWilayahModel->findAll();

        $data = [
            'judul' => 'map',
            'dataWilayah' => $dataWilayah
        ];

        if (empty($data['dataWilayah'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Halaman tidak ditemukan");
        }
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
