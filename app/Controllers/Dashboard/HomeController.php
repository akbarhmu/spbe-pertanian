<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\CommodityModel;
use App\Models\DesaModel;
use App\Models\KecamatanModel;
use App\Models\ReportModel;
use DateTime;

class HomeController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $bulanIni = $months[date('m') - 1];
        $bulanLalu = (date('m') == 1) ? $months[11] : $months[date('m') - 2];

        $reports = $db->table('reports_view')->select('nama_komoditas,luas,bulan,YEAR(created_at) as tahun,updated_at')
            ->whereIn('bulan', [$bulanIni, $bulanLalu])->where('YEAR(created_at)', date('Y'))->get()->getResultArray();

        $commoditiesModel = new CommodityModel();
        $commodities = $commoditiesModel->findAll();
        $commoditiesName = array_unique(array_column($commodities, 'name'));

        $desaModel = new DesaModel();
        $desa = $desaModel->orderBy('nm_desa', 'ASC')->findAll();

        $updatedAt = array_column($reports, 'updated_at');
        array_multisort($updatedAt, SORT_DESC, $reports);
        // $dateTime = new DateTime($reports[0]['updated_at']);
        // $latestUpdatedAt = $dateTime->format("d F Y");

        $data = [
            "bulan" => $bulanIni,
            "bulanLalu" => $bulanLalu,
            // "latest_updated_at" => $latestUpdatedAt,
            "months" => $months,
            "desa" => $desa,
            "komoditas" => []
        ];

        foreach ($commoditiesName as $commodityName) {
            $commodityReports = array_filter($reports, function ($report) use ($commoditiesName) {
                return in_array($report['nama_komoditas'], $commoditiesName);
            });

            $reportsBulanIni = array_filter($commodityReports, function ($report) use ($bulanIni, $commodityName) {
                return $report['bulan'] == $bulanIni && $report['tahun'] == date('Y') && $report['nama_komoditas'] == $commodityName;
            });
            $reportsBulanLalu = array_filter($commodityReports, function ($report) use ($bulanLalu, $commodityName) {
                return $report['bulan'] == $bulanLalu && $report['tahun'] == date('Y') && $report['nama_komoditas'] == $commodityName;
            });

            $totalBulanIni = 0;
            foreach ($reportsBulanIni as $report) {
                $totalBulanIni += $report['luas'];
            }

            $totalBulanLalu = 0;
            foreach ($reportsBulanLalu as $report) {
                $totalBulanLalu += $report['luas'];
            }

            $perubahanTotalLuas = $totalBulanIni - $totalBulanLalu;
            $persentasePerubahan = ($totalBulanLalu == $totalBulanIni) ? 0 : (($totalBulanLalu == 0) ? 100 : round(($perubahanTotalLuas / $totalBulanLalu) * 100, 2));

            $data['komoditas'][] = [
                "name" => $commodityName,
                "image" => array_column(array_filter($commodities, function ($commodity) use ($commodityName) {
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

        $currentUrl = current_url();
        $apiUrl = base_url(route_to('api.reports'));
        if ($currentUrl == $apiUrl) {
            $response = [
                'status' => 200,
                'message' => 'Success to get data',
                'data' => $data['komoditas'],
            ];
            return $this->response->setJSON($response);
        }

        return view('dashboard/index', $data);
    }

    public function report()
    {
        helper('form', 'form_helper');
        $request = service('request');

        $db = \Config\Database::connect();
        $kec = new KecamatanModel();

        $tahun = $request->getGet('tahun');
        if (!isset($tahun)) {
            $tahun = date('Y');
            $data['tahun'] = $tahun;
        } else {
            $data["tahun"] = $tahun;
        }
        $kecamatans = $kec->orderBy('nm_kec', 'ASC')->findAll();
        $komoditas = $request->getGet('tanaman');
        $months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $reports = $db->table('reports_view');

        $desaModel = new DesaModel();
        $desa = $desaModel->orderBy('nm_desa', 'ASC')->findAll();

        $data['kecamatans'] = $kecamatans;
        $data['years'] = $db->table('reports_view')->select('year(created_at) as years')->groupBy('year(created_at)')->orderBy('year(created_at) desc')->get()->getResultArray();
        $data['komoditas'] = $komoditas;
        $data['months'] = $months;
        $data['desa'] = $desa;
        $data['reports'] = [];

        foreach ($kecamatans as $kecamatan) {
            $luasBulanan = [];
            $totalLuas = 0;
            foreach ($months as $month) {
                $condSawah = [
                    'nm_kec' => $kecamatan['nm_kec'],
                    'bulan' => $month,
                    'nama_komoditas' => $komoditas,
                    'type' => 'Sawah'
                ];
                $condTegal = [
                    'nm_kec' => $kecamatan['nm_kec'],
                    'bulan' => $month,
                    'nama_komoditas' => $komoditas,
                    'type' => 'Tegal'
                ];
                $luasSawah = $reports->select('COALESCE(SUM(luas), 0) as luas')
                    ->where($condSawah)
                    ->where('YEAR(created_at)', $tahun)
                    ->get()->getRowArray();
                $luasTegal = $reports->select('COALESCE(SUM(luas), 0) as luas')
                    ->where($condTegal)
                    ->where('YEAR(created_at)', $tahun)
                    ->get()->getRowArray();
                $totalLuas += $luasTegal['luas'] + $luasSawah['luas'];
                $luasBulanan[] = [
                    'bulan' => $month,
                    'sawah' => $luasSawah['luas'],
                    'tegal' => $luasTegal['luas'],
                ];
            }

            $data['reports'][] = [
                'idKec' => $kecamatan['id_kec'],
                'namaKec' => $kecamatan['nm_kec'],
                'luasBulanan' => $luasBulanan,
                'totalLuas' => $totalLuas,
            ];
        }
        $jumlahBulanan = [];
        $jumlahTotal = 0;
        foreach ($months as $month) {
            $jumlahSawahBulanan = $reports->where('nama_komoditas', $komoditas)
                ->where('bulan', $month)
                ->where('type', 'Sawah')
                ->where('YEAR(created_at)', $tahun)
                ->select('COALESCE(SUM(luas), 0) as luas')
                ->get()->getRowArray();
            $jumlahTegalBulanan = $reports->where('nama_komoditas', $komoditas)
                ->where('bulan', $month)
                ->where('type', 'Tegal')
                ->where('YEAR(created_at)', $tahun)
                ->select('COALESCE(SUM(luas), 0) as luas')
                ->get()->getRowArray();
            $jumlahTotal += $jumlahTegalBulanan['luas'] + $jumlahSawahBulanan['luas'];
            $jumlahBulanan[] = [
                'bulan' => $month,
                'sawah' => $jumlahSawahBulanan['luas'],
                'tegal' => $jumlahTegalBulanan['luas'],
            ];
        }
        $data['jumlah'] = [
            'bulanan' => $jumlahBulanan,
            'total' => $jumlahTotal,
        ];

        $dataResponse = [
            'reports' => $data['reports'],
            'jumlah' => $data['jumlah']
        ];

        $response = [
            'data' => $dataResponse,
            'message' => 'Success to get data',
            'status' => 200,
        ];
        $currentUrl = current_url();
        $apiUrl = base_url(route_to('api.reports.kecamatan'));
        if ($currentUrl == $apiUrl) {
            return $this->response->setJSON($response);
        }
        return view('dashboard/report', $data);
    }
}
