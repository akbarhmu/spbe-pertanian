<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\CommodityModel;
use App\Models\KecamatanModel;
use App\Models\ReportModel;
use DateTime;

class HomeController extends BaseController
{
    public function index()
    {
        $months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bulanIni = $months[date('m')-1];
        $bulanLalu = (date('m') == 1) ? $months[11] : $months[date('m')-2];

        $reportsModel = new ReportModel();
        $reports = $reportsModel->select('id_commodity,luas,bulan,YEAR(created_at) as tahun,updated_at')->whereIn('bulan', [$bulanIni, $bulanLalu])->where('YEAR(created_at)', date('Y'))->findAll();

        $commoditiesModel = new CommodityModel();
        $commodities = $commoditiesModel->findAll();
        $commoditiesName = array_unique(array_column($commodities, 'name'));

        $updatedAt = array_column($reports, 'updated_at');
        array_multisort($updatedAt, SORT_DESC, $reports);
        $dateTime = new DateTime($reports[0]['updated_at']);
        $latestUpdatedAt = $dateTime->format("d F Y");

        $data = [
            "bulan" => $bulanIni,
            "bulanLalu" => $bulanLalu,
            "latest_updated_at" => $latestUpdatedAt,
            "komoditas" => []
        ];

        foreach($commoditiesName as $commodityName) {
            $listIdKomoditas = array_column(array_filter($commodities, function($commodity) use($commodityName) {
                return $commodity['name'] == $commodityName;
            }), 'id');

            $commodityReports = array_filter($reports, function($report) use($listIdKomoditas) {
                return in_array($report['id_commodity'], $listIdKomoditas);
            });

            $reportsBulanIni = array_filter($commodityReports, function($report) use ($bulanIni) {
                return $report['bulan'] == $bulanIni && $report['tahun'] == date('Y');
            });
            $reportsBulanLalu = array_filter($commodityReports, function($report) use ($bulanLalu) {
                return $report['bulan'] == $bulanLalu && $report['tahun'] == date('Y');
            });

            $totalBulanIni = 0;
            foreach($reportsBulanIni as $report) {
                $totalBulanIni += $report['luas'];
            }

            $totalBulanLalu = 0;
            foreach($reportsBulanLalu as $report) {
                $totalBulanLalu += $report['luas'];
            }

            $perubahanTotalLuas = $totalBulanIni - $totalBulanLalu;
            $persentasePerubahan = ($totalBulanLalu == $totalBulanIni) ? 0 : (($totalBulanLalu == 0) ? 100 : round(($perubahanTotalLuas / $totalBulanLalu) * 100, 2));

            $data['komoditas'][] = [
                "name" => $commodityName,
                "image" => array_column(array_filter($commodities, function($commodity) use($commodityName) {
                    return $commodity['name'] == $commodityName;
                }), 'image')[0],
                "totalBulanIni" => $totalBulanIni,
                "totalBulanLalu" => $totalBulanLalu,
                "perubahanTotalLuas" => $perubahanTotalLuas,
                "persentasePerubahan" => $persentasePerubahan,
                "class" => ($perubahanTotalLuas == 0) ? "secondary" : (($perubahanTotalLuas > 0) ? "success" : "danger"),
                "icon" => ($perubahanTotalLuas == 0) ? "=" : (($perubahanTotalLuas > 0) ? "▲" : "▼"),
            ];
        }

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
