<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KecamatanModel;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        helper('form', 'form_helper');
        return view('auth/login.php');
    }

    public function login()
    {
        $validation = \Config\Services::validation();
        $validation->withRequest($this->request);
        $validation->loadRuleGroup('login');

        if (!$validation->run()) {
            return redirect()->back()->withInput();
        } else {
            $userModel = new UserModel();
            $validatedData = $validation->getValidated();

            $user = $userModel->where('email', $validatedData['email'])->first();

            if ($user) {
                if (password_verify($validatedData['password'], $user['password'])) {
                    if ($user['verified_at'] == null) {
                        session()->setFlashdata('alert_message', [
                            'type' => 'danger',
                            'message' => 'Akun anda belum diverifikasi. Mohon menunggu konfirmasi admin.',
                            'icon' => 'fa-solid fa-xmark'
                        ]);
                        return redirect()->back();
                    } else {
                        $data = [
                            'id' => $user['id'],
                            'name' => $user['name'],
                            'email' => $user['email'],
                            'phone_number' => $user['phone_number'],
                            'id_kec' => $user['id_kec'],
                            'verified_at' => $user['verified_at'],
                            'isLoggedIn' => true,
                            'role' => $user['role'],
                        ];

                        session()->set($data);
                        session()->setFlashdata('alert_message', [
                            'type' => 'success',
                            'message' => 'Login berhasil',
                            'icon' => 'fa-solid fa-check'
                        ]);

                        return redirect()->to('/dashboard');
                    }
                } else {
                    session()->setFlashdata('alert_message', [
                        'type' => 'danger',
                        'message' => 'Login gagal. Periksa kembali email dan password anda.',
                        'icon' => 'fa-solid fa-xmark'
                    ]);
                    return redirect()->back()->withInput();
                }
            } else {
                session()->setFlashdata('alert_message', [
                    'type' => 'danger',
                    'message' => 'Login gagal. Periksa kembali email dan password anda.',
                    'icon' => 'fa-solid fa-xmark'
                ]);
                return redirect()->back();
            }
        }
    }

    public function register()
    {
        helper('form', 'form_helper');
        $kecamatans = new KecamatanModel();
        $data["kecamatans"] = $kecamatans->orderBy('nm_kec', 'ASC')->findAll();
        return view('auth/register.php', $data);
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
                    "id_kec" => $kecamatan,
                ];

                $user = new UserModel();

                $user->insert($data);
                session()->setFlashdata('alert_message', [
                    'type' => 'success',
                    'message' => 'Akun berhasil dibuat. Silahkan menunggu konfirmasi admin.',
                    'icon' => 'fa-solid fa-check'
                ]);
                return redirect()->to('/login');
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

    public function logout()
    {
        session()->destroy();
        session()->setFlashdata('alert_message', [
            'type' => 'success',
            'message' => 'Logout berhasil',
            'icon' => 'fa-solid fa-check'
        ]);
        return redirect()->to('/login');
    }
}
