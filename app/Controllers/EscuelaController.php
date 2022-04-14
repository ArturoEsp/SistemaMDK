<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Escuela;
use App\Models\Participante;
use Exception;

class EscuelaController extends BaseController
{
    public function index()
    {
        return view('front/escuelas/escuelas');
    }

    public function getListTeachers ()
    {
        try {
            $participanteModel = new Participante();
            $msgResponse = ['status' => 'ok', 'data' => ''];
    
            $teachers = $participanteModel->join('tipo_usuario', 'tipo_usuario.id_tu = participantes.id_tu')
                                          ->where('tipo_usuario.tu_descrip', 'Maestro')
                                          ->findAll();
            $msgResponse['data'] = $teachers;
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }
        return $this->response->setJSON($msgResponse);
    }

    public function store ()
    {
        $escuela = new Escuela();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {
            $data = [
                'nombre' => $this->request->getVar('name'),
                'direccion' => $this->request->getVar('address'),
                'id_participante' => $this->request->getVar('teacher')
            ];
    
            $escuela->save($data);
            $msgResponse['data'] = $escuela;
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function deleteSchool ($id) 
    {
        $escuela = new Escuela();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {
            $escuela->where('id_escuela', $id)->delete();
            $msgResponse['data'] = 'Eliminación correcta.';
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }


    public function getSchools () 
    {
        $escuelas = new Escuela();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {
            $findSchools = $escuelas
                            ->select('id_escuela as IdEscuela, escuelas.nombre as NombreEscuela, escuelas.direccion as DireccionEscuela,
                                    participantes.nombres as NombreMaestro, participantes.apellidos as ApellidoMaestro')
                            ->join('participantes', 'escuelas.id_participante = participantes.id_alumno')->findAll();
            $msgResponse['data'] = $findSchools;
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);

    }

    public function getStudentsBySchool ($id) 
    {
        $escuela = new Escuela();
        $participantes = new Participante();

        
    }
}
