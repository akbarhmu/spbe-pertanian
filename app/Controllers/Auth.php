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
        helper('form', 'form_helper');
        $kecamatans = new KecamatanModel();
        $data["kecamatans"] = $kecamatans->findAll();
        return view('register.php', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->withRequest($this->request);
        $validation->loadRuleGroup('register');

        if (!$validation->run()) {
            return redirect()->back()->withInput();
        } else {
            try {
                $validatedData = $validation->getValidated();
    
                $name = $validatedData['name'];
                $email = $validatedData['email'];
                $phoneNumber = $validatedData['phoneNumber'];
                $password = $validatedData['password'];
                $kecamatan = $validatedData['kecamatan'];
        
                $data = [
                    "name" => $name,
                    "email" => $email,
                    "phone_number" => $phoneNumber,
                    "password" => password_hash($password, PASSWORD_DEFAULT),
                    "kecamatan_id" => $kecamatan,
                ];
        
                $user = new UserModel();
        
                $user->insert($data);
        
                session()->setFlashdata('alert_message', [
                    'type' => 'success',
                    'message' => 'Akun berhasil dibuat',
                    'icon' => 'fa-solid fa-check'
                ]);
            } catch (\Throwable $th) {
                session()->setFlashdata('alert_message', [
                    'type' => 'danger',
                    'message' => 'Akun gagal dibuat',
                    'icon' => 'fa-solid fa-xmark'
                ]);
            }
            return redirect()->back();
        }
    }
}
