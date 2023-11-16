<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        helper('form', 'form_helper');
        $data["months"] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('dashboard/index', $data);
    }
}
