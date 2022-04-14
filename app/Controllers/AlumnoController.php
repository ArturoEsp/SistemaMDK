<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TipoAlumno;
use App\Models\Categoria;
use App\Models\Participante;
use App\Models\Escuela;
use App\Models\Nivel;
use App\Models\EstudiantesEscuela;
use App\Models\EventoParticipantes;
use App\Models\Grado;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\MySQLi\Builder;
use Exception;

class AlumnoController extends BaseController
{

    private $estudianteModel;
    private $estudianteEscuelaModel;
    private $estudiantesEventoModel;
    private $gradoModel;

    public function __construct()
    {
        $this->estudianteModel = new Participante();
        $this->estudianteEscuelaModel = new EstudiantesEscuela();
        $this->estudiantesEventoModel = new EventoParticipantes();
        $this->gradoModel = new Grado();
    }

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
            'tipos_alumno' => $tiposAlumno->findAll(),
            'grados' => $this->gradoModel->findAll(),
        ];

        return view('front/participantes/participantes', $data);
    }

    public function editParticipanteView()
    {
        $id =  session('data_user')['idUser'];
        $escuela = new Escuela();
        $tiposAlumno = new TipoAlumno();

        $data = [
            'schools' => $escuela->getSchoolsByTeacher($id),
            'tipos_alumno' => $tiposAlumno->findAll()
        ];
        return view('front/participantes/editar_participante', $data);
    }

    public function registroEvento()
    {
        $session = session();
        $id =  $session->get('data_user')['idUser'];
        $event = session('event');

        if (!$event) {
            return redirect()->back();
        }

        $escuela = new Escuela();
        $data = [
            'schools' => $escuela->getSchoolsByTeacher($id),
        ];

        return view('front/participantes/registro_evento', $data);
    }

    public function getParticipanteById($id)
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        try {

            $participante = $this->estudianteModel
                ->join('estudiantes_escuela as EE', 'EE.id_estudiante = participantes.id_alumno')
                ->find($id);

            $msgResponse['data'] = $participante;
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function getParticipantesByEscuela($id)
    {
        $relation = new EstudiantesEscuela();
        $alumno = new Participante();
        $msgResponse = ['status' => 'ok', 'data' => ''];

        $findStudents = $relation->where('id_escuela', $id)->findAll();

        $arrayStudents = [];

        foreach ($findStudents as $student) {
            $find = $alumno->select('
                participantes.id_alumno,
                participantes.nombres,
                participantes.apellidos,
                participantes.edad,
                participantes.fotografia,
                participantes.peso,
                participantes.altura,
                participantes.sexo,
                CAT.nom_cat,
                NIV.descrip_niv
            ')
                ->join('categoria as CAT', 'CAT.id_categoria = participantes.id_categoria')
                ->join('nivel as NIV', 'NIV.id_nivel = participantes.id_nivel')
                ->find($student['id_estudiante']);
            array_push($arrayStudents, $find);
        }

        $msgResponse['data'] = $arrayStudents;

        return $this->response->setJSON($msgResponse);
    }

    public function getParticipantesForEvent($id_escuela, $id_mod)
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        $id_event = session('event')['id'];
        $findStudents = $this->estudianteEscuelaModel->where('id_escuela', $id_escuela)->findAll();

        $arrayStudents = [];

        foreach ($findStudents as $student) {
            $find = $this->estudianteModel->select('
                participantes.id_alumno,
                participantes.nombres,
                participantes.apellidos,
                participantes.edad,
                participantes.fotografia,
                participantes.peso,
                participantes.altura,
                participantes.sexo,
                CAT.nom_cat,
                NIV.descrip_niv
            ')
                ->join('categoria as CAT', 'CAT.id_categoria = participantes.id_categoria')
                ->join('nivel as NIV', 'NIV.id_nivel = participantes.id_nivel')
                ->where("participantes.id_alumno", $student['id_estudiante'])
                ->whereNotIn('participantes.id_alumno', function (Builder $builder) use ($id_event, $id_mod) {
                    return $builder->select('id_participante')
                        ->from('evento_participantes')
                        ->where('id_evento', $id_event)
                        ->where('id_modalidad', $id_mod);
                })
                ->first();
            if ($find) {
                array_push($arrayStudents, $find);
            }
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
                'id_grado' => $this->request->getVar('grade_id'),
                'fotografia' => $photoName
            ];

            $newAlumno = $this->estudianteModel->insert($data, true);
            
            $data = [
                'id_escuela'    => (int)$this->request->getVar('school_id'),
                'id_estudiante' => $newAlumno
            ];

            $this->estudianteEscuelaModel->insert($data, true);
            $msgResponse['data'] = 'Alumnos registrado';
        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function update($alumno_id)
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {
            $findAlumno = $this->estudianteModel->find($alumno_id);
            $file = $this->request->getFile('photo');
            $photoName = null;

            if (!$findAlumno) {
                $msgResponse['status'] = 'error';
                $msgResponse['data'] = 'No se encontró el participante.';
            }

            if ($file) {
                if ($findAlumno['fotografia']) {
                    unlink("uploads/" . $findAlumno['fotografia']);
                }

                if ($file->isValid() && !$file->hasMoved()) {
                    $photoName = $file->getRandomName();
                    $file->move('uploads/', $photoName);
                }
            }

            $data = [];
            if ($this->request->getVar('name')) $data['nombres'] = $this->request->getVar('name');
            if ($this->request->getVar('lastname')) $data['apellidos'] = $this->request->getVar('lastname');
            if ($this->request->getVar('sexo')) $data['sexo'] = $this->request->getVar('sexo');
            if ($this->request->getVar('age')) $data['edad'] = $this->request->getVar('age');
            if ($this->request->getVar('height')) $data['altura'] = $this->request->getVar('height');
            if ($this->request->getVar('weight')) $data['peso'] = $this->request->getVar('weight');
            if ($this->request->getVar('type_student')) $data['id_ta'] = $this->request->getVar('type_student');
            if ($this->request->getVar('type_category')) $data['id_categoria'] = $this->request->getVar('type_category');
            if ($this->request->getVar('type_nivel')) $data['id_nivel'] = $this->request->getVar('type_nivel');
            if ($photoName) $data['fotografia'] = $photoName;


            $this->estudianteModel->update($alumno_id, $data);
            $msgResponse['data'] = "Actualización correcta";

        } catch (Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }
}
