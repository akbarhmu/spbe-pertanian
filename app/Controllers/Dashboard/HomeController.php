<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
    public function index()
    {
        helper('form', 'form_helper');
        return view('dashboard/index');
    }
}
