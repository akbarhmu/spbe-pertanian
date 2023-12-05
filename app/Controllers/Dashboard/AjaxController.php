<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\CommodityModel;
use App\Models\ReportModel;

class AjaxController extends BaseController
{
    public function getDetailLuasPerBulan()
    {
        $kecamatan = $this->request->getPost('kecamatan');
        $tahun = $this->request->getPost('tahun');
        $bulan = $this->request->getPost('bulan');
        $komoditas = $this->request->getPost('komoditas');
        $type = $this->request->getPost('type');

        $commodity = new CommodityModel();
        $id_commodity = $commodity->where('name', $komoditas)->where('type', $type)->first()['id'];

        $report = new ReportModel();
        $result = $report->select('nm_desa, SUM(luas)')
                    ->join('mst_desa', 'mst_desa.id_desa = reports.id_desa')
                    ->where('id_commodity', $id_commodity)
                    ->where('reports.id_kec', $kecamatan)
                    ->where('YEAR(created_at)', $tahun)
                    ->where('bulan', $bulan)
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
