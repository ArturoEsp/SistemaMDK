<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\Area;

class AreaController extends BaseController
{
    public function index()
    {
        return view('front/areas/areas');
    }

    public function store()
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        try {
            $area = new Area();
            $data = [
                'nombre' => $this->request->getVar('name'),
                'status' => $this->request->getVar('status')
            ];
            $area->save($data);
            $msgResponse['data'] = 'Área creada correctamente.';
        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function update($id)
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        try {

            $area = new Area();
            $dataUpdate = [];
            
            if ($this->request->getVar('name'))
                $dataUpdate['name'] = $this->request->getVar('name');

            if ($this->request->getVar('status') === '0' || $this->request->getVar('status') === '1')
                $dataUpdate['status'] = $this->request->getVar('status');

            $area->update($id, $dataUpdate);
            $msgResponse['data'] = 'Área actualizada correctamente.';

        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function delete ($id)
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        try {

            $area = new Area();

            $area->delete($id);
            $msgResponse['data'] = 'Área eliminada correctamente.';

        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function getAllAreas()
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {

            $area = new Area();
            $msgResponse['data'] = $area->getAreaByStatus();
        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }
        return $this->response->setJSON($msgResponse);
    }
}
