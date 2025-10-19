<?php

namespace App\Models;

use CodeIgniter\Model;

class DataWilayahModel extends Model
{
    protected $table = 'datakebakaran';
    protected $primaryKey = 'id';
    // protected $returnType = 'object';
    protected $allowedFields = [
        'id',
        'tglKejadian',
        'waktuKejadian',
        'kabKota',
        'kecamatan',
        'latitude',
        'longitude',
        'jenisObjek',
        'penyebab',
        'jmlBangunan',
        'korbanMeninggal',
        'korbanLuka',
        'kerugian',
        'waktuRespon',
        'jmlPersonil',
        'jmlArmada',
        'sumberInfo',
        'keterangan'
    ];

    public function getWilayah($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->where(['id' => $id])->first();
    }

    public function getJumlahByKecamatan()
    {
        $results = $this->select('kecamatan, COUNT(*) as jumlah')
            ->groupBy('Kecamatan')
            ->findAll();

        $output = [];
        foreach ($results as $row) {
            $output[$row['kecamatan']] = (int) $row['jumlah'];
        }

        return $output;
    }

    // public function insertData($data)
    // {
    //     $this->db->table('wilayah')->insert($data);
    // }
}
