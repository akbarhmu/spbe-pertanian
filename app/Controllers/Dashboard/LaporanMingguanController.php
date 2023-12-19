<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\DesaModel;
use App\Models\ReportModel;

class LaporanMingguanController extends BaseController
{
    public function index()
    {
        $bulan = $this->request->getGet('bulan');
        $id_desa = $this->request->getGet('id_desa');
        $type = $this->request->getGet('type');

        $desa = new DesaModel();
        $reports = new ReportModel();
        $reports->join('commodities', 'commodities.id = reports.id_commodity');

        if ($bulan) {
            $reports = $reports->where('bulan', $bulan);
        }

        if ($id_desa) {
            $reports = $reports->where('id_desa', $id_desa);
        }

        if ($type) {
            $reports = $reports->where('type', $type);
        }

        $data['reports'] = $reports->findAll();
        $data['months'] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober", "November", "Desember"];
        $data['desa'] = $desa->orderBy('nm_desa', 'ASC')->findAll();
        $data['bulan'] = $bulan;
        $data['id_desa'] = $id_desa;
        $data['type'] = $type;

        return view('reports/index', $data);
    }
}
