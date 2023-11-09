<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KecamatanModel;
use App\Models\KelurahanModel;

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
}
