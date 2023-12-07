<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\CommodityModel;
use App\Models\ReportModel;
use App\Models\KecamatanModel;

class AjaxController extends BaseController
{
    public function getDetailLuasPerBulan()
    {
        $db = \Config\Database::connect();
        $kec = new KecamatanModel();

        $kecamatan = $this->request->getPost('kecamatan');
        $tahun = $this->request->getPost('tahun');
        $bulan = $this->request->getPost('bulan');
        $komoditas = $this->request->getPost('komoditas');
        $type = $this->request->getPost('type');

        $namaKec = $kec->select('nm_kec')->where('id_kec', $kecamatan)->first();

        $commodity = new CommodityModel();
        // $id_commodity = $commodity->where('name', $komoditas)->where('type', $type)->first()['id'];

        $report = $db->table('reports_view');
        $result = $report->select('nm_desa, SUM(luas)')
            ->where('nama_komoditas', $komoditas)
            ->where('nm_kec', $namaKec)
            ->where('YEAR(created_at)', $tahun)
            ->where('bulan', $bulan)
            ->where('type', $type)
            ->groupBy('nm_desa')
            ->get()->getResultArray();

        $response = [
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => [],
        ];
        foreach ($result as $key => $value) {
            $response['data'][] = [
                'name' => $value['nm_desa'],
                'luas' => (float) $value['SUM(luas)'],
            ];
        }

        return $this->response->setJSON($response);
    }
}
