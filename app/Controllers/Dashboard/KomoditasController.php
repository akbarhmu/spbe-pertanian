<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\CommodityModel;

class KomoditasController extends BaseController
{
    public function index()
    {
        helper('form', 'form_helper');
        $commodities = new CommodityModel();
        $data["commodities"] = $commodities->findAll();
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

            $commodities = new CommodityModel();
            $commodities->insert([
                'name' => $validatedData['name']
            ]);
            session()->setFlashdata('alert_message', [
                'type' => 'success',
                'message' => 'Komoditas berhasil ditambahkan',
                'icon' => 'fa-solid fa-check'
            ]);
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
            session()->setFlashdata('alert_message', [
                'type' => 'success',
                'message' => 'Komoditas berhasil diubah',
                'icon' => 'fa-solid fa-check'
            ]);
            return redirect()->route('komoditas.index');
        }
    }

    public function destroy($id)
    {
        $commodities = new CommodityModel();
        $commodities->delete($id);
        return redirect()->route('komoditas.index');
    }
}
