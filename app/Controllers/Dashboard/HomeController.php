<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\KecamatanModel;
use App\Models\ReportModel;

class HomeController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        helper('form', 'form_helper');

        $kec = new KecamatanModel();
        $data["kecamatans"] = $kec->findAll();
        $data["reports"] = $db->table('reports_view');
        $data["months"] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        // $data["januari"] = $report->select('id_kec,id_desa,bulan,luas')->selectMax('minggu')->groupBy('id_kec,id_desa,bulan, luas, tipe_komoditas')->find();
        // dd($data);   

        return view('dashboard/index', $data);
    }
}
