<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\CommodityModel;
use App\Models\KecamatanModel;
use App\Models\ReportModel;

class HomeController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        helper('form', 'form_helper');
        $komoditas = new CommodityModel();
        $data["komoditas"] = $komoditas->select('name')->groupBy('name')->findAll();

        return view('dashboard/index', $data);
    }
    public function report($komoditas)
    {
        helper('form', 'form_helper');

        $db = \Config\Database::connect();
        $kec = new KecamatanModel();

        $data["kecamatans"] = $kec->findAll();
        $data["reports"] = $db->table('reports_view');
        $data["months"] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $data["komoditas"] = $komoditas;
        return view('dashboard/report', $data);
    }
}
