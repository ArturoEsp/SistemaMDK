<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TipoAlumno;
use App\Models\Categoria;
use App\Models\Participante;
use App\Models\Escuela;
use App\Models\Nivel;
use App\Models\EstudiantesEscuela;
use Exception;

class AlumnoController extends BaseController
{
    public function index()
    {
    }

    public function participantesView()
    {
        $session = session();

        $id =  $session->get('data_user')['idUser'];
        $escuela = new Escuela();
        $tiposAlumno = new TipoAlumno();

        $data = [
            'schools' => $escuela->getSchoolsByTeacher($id),
            'tipos_alumno' => $tiposAlumno->findAll()
        ];

        return view('front/participantes/participantes', $data);
    }

    public function getParticipantesByEscuela($id)
    {
        $relation = new EstudiantesEscuela();
        $alumno = new Participante();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        $findStudents = $relation->where('id_escuela', $id)->findAll();

       $arrayStudents = [];

        foreach ($findStudents as $student) {
            $find = $alumno->find($student['id_estudiante']);
            array_push($arrayStudents, $find);
        } 
        
        $msgResponse['data'] = $arrayStudents;

        return $this->response->setJSON($msgResponse);
    }

    public function getTypesStudent()
    {
        $types = new TipoAlumno();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {
            $msgResponse['data'] = $types->findAll();
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function getCategoriesByGenreAndWeight($weight, $genre)
    {
        $categoria = new Categoria();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {
            $msgResponse['data'] = $categoria->getCategoriesByFilter($weight, $genre);
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function getLevelsByAge($age = 0)
    {
        $nivel = new Nivel();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {
            $msgResponse['data'] = $nivel->getLevelsByFilter($age);
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function store()
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {

            $alumno = new Participante();
            $photoName = null;

            $file = $this->request->getFile('photo');

            if ($file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $photoName = $file->getRandomName();
                    $file->move('uploads/', $photoName);
                }
            }

            $data = [
                'nombres' => $this->request->getVar('name'),
                'apellidos' => $this->request->getVar('lastname'),
                'sexo' => $this->request->getVar('sexo'),
                'edad' => $this->request->getVar('age'),
                'altura' => $this->request->getVar('height'),
                'peso' => $this->request->getVar('weight'),
                'id_ta' => $this->request->getVar('type_student'),
                'id_categoria' => $this->request->getVar('type_category'),
                'id_nivel' => $this->request->getVar('type_nivel'),
                'fotografia' => $photoName
            ];

            $alumno->insert($data);
            $id_alumno = $alumno->getInsertID();

            $relationsSchool = new EstudiantesEscuela();
            $data = [
                'id_escuela'    => (int)$this->request->getVar('school_id'),
                'id_estudiante' => $id_alumno
            ];
        
            $relationsSchool->insert($data); 
    
            $msgResponse['data'] = 'Alumnos registrado';

        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }
}
