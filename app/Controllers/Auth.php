<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KecamatanModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
    }
    public function register()
    {
        $kecamatans = new KecamatanModel();
        $data["kecamatans"] = $kecamatans->findAll();
        return view('register.php', $data);
    }
    public function store()
    {
        $name = $this->request->getVar('name');
        $email = $this->request->getVar('email');
        $phoneNumber = $this->request->getVar('phoneNumber');
        $password = $this->request->getVar('password');
        $retypePassword = $this->request->getVar('retypePassword');
        $kecamatan = $this->request->getVar('kecamatan');

        if ($password !== $retypePassword) {
            return redirect()->back();
        }

        $data = [
            "name" => $name,
            "email" => $email,
            "phone_number" => $phoneNumber,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "kecamatan_id" => $kecamatan,
        ];

        $user = new UserModel();

        $user->insert($data);

        return redirect()->back();
    }
}
