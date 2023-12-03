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
        $report = new ReportModel();
        $komoditas = new CommodityModel();
        $data["komoditas"] = $komoditas->select('name,created_at')->groupBy('name,created_at')->findAll();
        $data["reports"] = $db->table('reports_view');


        return view('dashboard/index', $data);
    }
    public function report($komoditas)
    {
        helper('form', 'form_helper');
        $request = service('request');

        $db = \Config\Database::connect();
        $kec = new KecamatanModel();

        $tahun = $request->getGet('tahun');
        if (!isset($tahun)) {
            $data["tahun"] = date('Y');
        } else {
            $data["tahun"] = $tahun;
        }
        $data["kecamatans"] = $kec->orderBy('nm_kec', 'ASC')->findAll();
        $data["reports"] = $db->table('reports_view');
        $data["months"] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $data['years'] = $db->table('reports_view')->select('year(created_at) as years')->groupBy('year(created_at)')->orderBy('year(created_at) desc')->get()->getResultArray();
        $data["komoditas"] = $request->getGet('tanaman');

        return view('dashboard/report', $data);
    }
}
