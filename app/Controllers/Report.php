<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\ReportModel;
use App\Models\UserModel;

class Report extends BaseController
{
    public function index()
    {
        helper('form', 'form_helper');
        $kecamatans = new KecamatanModel();
        $kelurahans = new KelurahanModel();
        $data["name"] = session()->get('name');
        $kec_id = session()->get('id_kec');
        $data["kecamatan"] = $kecamatans->where('id', $kec_id)->findAll();
        $data["weeks"] = ["1 (Satu)", "2 (Dua)", "3 (Tiga)", "4 (Empat)", "5 (Lima)"];
        $data["months"] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $data["kecamatans"] = $kecamatans->findAll();
        $data["kelurahans"] = $kelurahans->where("id_kec", $kec_id)->findAll();

        return view('form.php', $data);
    }
    public function store()
    {
        // $dataPost = $this->request->getPost();
        $validation = \Config\Services::validation();
        $validation->withRequest($this->request);
        $validation->loadRuleGroup('report');


        if (!$validation->run()) {
            // dd($validation);
            return redirect()->back()->withInput();
        } else {
            try {
                $lahan = new ReportModel();
                $validatedData = $validation->getValidated();
                $month = $validatedData['month'];
                $week = $validatedData['week'];
                $kelurahan = $validatedData['kelurahan'];

                foreach ($validatedData['lahan'] as $key => $value) {
                    $data = [
                        "id_user" => session()->get('id'),
                        "id_desa" => $kelurahan,
                        "id_kec" => session()->get('id_kec'),
                        "minggu" => $week,
                        "bulan" => $month,
                        "tipe_komoditas" => $key,
                        'luas' => $value,
                    ];
                    $lahan->insert($data);
                };

                session()->setFlashdata('alert_message', [
                    'type' => 'success',
                    'message' => 'Data berhasil dibuat',
                    'icon' => 'fa-solid fa-check'
                ]);
                return redirect()->to('/dashboard');
            } catch (\Throwable $th) {
                session()->setFlashdata('alert_message', [
                    'type' => 'danger',
                    'message' => 'Data gagal dibuat',
                    'icon' => 'fa-solid fa-xmark'
                ]);
                // dd($th->getMessage());
                return redirect()->back();
            }
        }
    }
}
