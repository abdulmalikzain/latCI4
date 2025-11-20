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

    public function getJumlahByKabupatenKecamatan($tanggal = null)
    {
        $builder = $this->select('kabKota, kecamatan, COUNT(*) as jumlah');

        // Jika tanggal dipilih, tambahkan filter
        if ($tanggal) {
            $builder->where('tglKejadian', $tanggal);
        }

        $builder->groupBy(['kabKota', 'kecamatan']);
        $results = $builder->findAll();

        if (empty($results)) {
            return [
                'status' => 'kosong',
                'message' => 'Data kosong'
            ];
        }

        $output = [];
        foreach ($results as $row) {
            $kabKota = $row['kabKota'];
            $kecamatan = $row['kecamatan'];
            $jumlah = (int) $row['jumlah'];

            if (!isset($output[$kabKota])) {
                $output[$kabKota] = [];
            }

            $output[$kabKota][$kecamatan] = $jumlah;
        }


        return $output;
    }

    public function getFilteredData($kabKota = null, $startDate = null, $endDate = null, $isAdmin = false, $wilayahUser = null)
    {
        $builder = $this->builder();

        // ======== FILTER KAB/KOTA =========
        if ($isAdmin) {
            // Admin bebas pilih apa saja
            if (!empty($kabKota)) {
                $builder->where('kabKota', $kabKota);
            }
        } else {
            // User biasa hanya wilayah sendiri
            $builder->where('kabKota', $wilayahUser);
        }

        // ======== FILTER TANGGAL =========
        if (!empty($startDate) && !empty($endDate)) {
            $builder->where('tglKejadian >=', $startDate);
            $builder->where('tglKejadian <=', $endDate);
        } elseif (!empty($startDate)) {
            $builder->where('tglKejadian', $startDate);
        }

        return $builder;
    }


    public function getKabKotaList()
    {
        return $this->select('kabKota')->distinct()->findAll();
    }
}
