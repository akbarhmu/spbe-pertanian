<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\CommodityModel;
use App\Models\DesaModel;

class KomoditasController extends BaseController
{
    public function index()
    {
        helper('form', 'form_helper');
        $commodities = new CommodityModel();
        $data["commodities"] = $commodities->findAll();
        $data["typeLahans"] = ["Sawah", "Tegal"];
        $data["months"] = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
            "Agustus", "September", "Oktober", "November", "Desember"];

        $desaModel = new DesaModel();
        $desa = $desaModel->orderBy('nm_desa', 'ASC')->findAll();
        $data["desa"] = $desa;
        return view('commodity/index.php', $data);
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->withRequest($this->request);
        $validation->loadRuleGroup('create_commodity');

        if (!$validation->run()) {
            return redirect()->back()->withInput();
        } else {
            $validatedData = $validation->getValidated();

            $image = $this->request->getFile('image');
            $fileName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/assets/images/commodities', $fileName);

            $commodities = new CommodityModel();
            $commodities->insert([
                'name' => $validatedData['name'],
                'image' => '/assets/images/commodities/' . $fileName,
                'type' => $validatedData['typeLahan'],
            ]);
            
            session()->setFlashdata("success", "Komoditas berhasil ditambahkan");
            return redirect()->route('komoditas.index');
        }
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->withRequest($this->request);
        $validation->loadRuleGroup('update_commodity');

        if (!$validation->run()) {
            return redirect()->back()->withInput();
        } else {
            $validatedData = $validation->getValidated();

            $commodities = new CommodityModel();
            $commodities->update($id, [
                'name' => $validatedData['name']
            ]);
            
            session()->setFlashdata("success", "Komoditas berhasil diubah");
            return redirect()->route('komoditas.index');
        }
    }

    public function destroy($id)
    {
        $commodities = new CommodityModel();
        $commodities->delete($id);

        session()->setFlashdata("success", "Komoditas berhasil dihapus");
        return redirect()->route('komoditas.index');
    }
}
