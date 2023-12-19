<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\DesaModel;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->with('kecamatan')->findAll();
        $data['months'] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober", "November", "Desember"];

        $desaModel = new DesaModel();
        $desa = $desaModel->orderBy('nm_desa', 'ASC')->findAll();
        $data["desa"] = $desa;

        return view('users/index', $data);
    }

    public function verify($id)
    {
        $userModel = new UserModel();
        $userModel->update($id, ['verified_at' => date('Y-m-d H:i:s')]);

        session()->setFlashdata("success", "Pengguna berhasil diverifikasi");

        return redirect()->back();
    }

    public function destroy($id)
    {
        $userModel = new UserModel();
        $userModel->delete($id);

        session()->setFlashdata("success", "Pengguna berhasil dihapus");

        return redirect()->back();
    }
}
