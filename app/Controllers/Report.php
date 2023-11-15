<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;
use App\Models\LahanModel;
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
        // $posttt = $this->request->getPost('lahan');
        // dd(array_keys($posttt));
        $lahan = new LahanModel();

        $validation = \Config\Services::validation();
        $validation->withRequest($this->request);
        $validation->loadRuleGroup('lahan');

        if (!$validation->run()) {
            return redirect()->back()->withInput();
        } else {
            try {

                $validatedData = $validation->getValidated();

                $month = $validatedData['month'];
                $week = $validatedData['week'];
                $kelurahan = $validatedData['kelurahan'];
                $luas_padi_sawah = $validatedData['luas_padi_sawah'];
                $luas_padi_tegal = $validatedData['luas_padi_tegal'];
                $luas_jagung_sawah = $validatedData['luas_jagung_sawah'];
                $luas_jagung_tegal = $validatedData['luas_jagung_tegal'];
                $luas_kedelai_sawah = $validatedData['luas_kedelai_sawah'];
                $luas_kedelai_tegal = $validatedData['luas_kedelai_tegal'];

                $data = [
                    "user_id" => session()->get('id'),
                    "desa_id" => $kelurahan,
                    "minggu" => $week,
                    "bulan" => $month,

                ];


                session()->setFlashdata('alert_message', [
                    'type' => 'success',
                    'message' => 'Akun berhasil dibuat',
                    'icon' => 'fa-solid fa-check'
                ]);
                return redirect()->to('/dashboard');
            } catch (\Throwable $th) {
                session()->setFlashdata('alert_message', [
                    'type' => 'danger',
                    'message' => 'Akun gagal dibuat',
                    'icon' => 'fa-solid fa-xmark'
                ]);
                dd($th->getMessage());
                return redirect()->back();
            }
        }
    }
}
