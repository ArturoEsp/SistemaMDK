<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Evento;
use App\Models\Modalidad;
use App\Models\Escuela;
use App\Models\EstudiantesEscuela;
use App\Models\EventoParticipantes;
use App\Models\Participante;
use CodeIgniter\Database\BaseBuilder;

class EventoController extends BaseController
{
    private $modalidadModel;
    private $eventoModel;
    private $escuelaModel;
    private $participantesEventoModel;
    private $escuelaEstudiantes;
    private $alumnoModel;

    public function __construct()
    {
        $this->modalidadModel = new Modalidad();
        $this->eventoModel = new Evento();
        $this->escuelaModel = new Escuela();
        $this->participantesEventoModel = new EventoParticipantes();
        $this->escuelaEstudiantes = new EstudiantesEscuela();
        $this->alumnoModel = new Participante();
    }

    public function index()
    {
        $event = session('event');
        if ($event)
            return view('front/eventos/evento_en_proceso');
        else
            return redirect()->to('/eventos/nuevo');
    }

    public function crearEvento()
    {
        $event = session('event');

        $data = [
            'modalidades' =>  $this->modalidadModel->getModalidades(),
        ];

        if (!$event)
            return view('front/eventos/crear_evento', $data);
        else
            return redirect()->to('/');
    }

    public function store()
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];

        try {

            $mods = $this->request->getVar('mods');
            $data = [
                'nombre' => $this->request->getVar('name'),
                'descripcion' => $this->request->getVar('description'),
                'fecha_inicio' => $this->request->getVar('date_start'),
                'fecha_fin' => $this->request->getVar('date_end'),
                'lugar' => $this->request->getVar('place'),
            ];

            $save = $this->eventoModel->storeData($data, $mods);
            if ($save === true) {
                $msgResponse['data'] = 'Evento creado correctamente.';
                $event = $this->eventoModel->eventInProcess();
                $session = session();
                $session->set(['event' => $event]);
            }
            if ($save === false) {
                $msgResponse['status'] = 'error';
                $msgResponse['data'] = 'Ocurrió un error al crear el evento, intentalo de nuevo.';
            }
        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function registerParticipantes()
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        try {
            $user_id = session('data_user')['idUser'];
            $event = session('event');
            $school_id = $this->request->getVar('school_id');
            $participantes = $this->request->getVar('students_id');
            $modalidad_id = $this->request->getVar('mod_id');

            $existSchool = $this->escuelaModel->where('id_escuela', $school_id)->where('id_participante', $user_id)->first();

            if (!$existSchool) {
                $msgResponse['status'] = 'error';
                $msgResponse['data'] = 'Esta escuela no te pertenece.';
                return $this->response->setJSON($msgResponse);
            }

            if (!$event) {
                $msgResponse['status'] = 'error';
                $msgResponse['data'] = 'No hay un evento disponible.';
                return $this->response->setJSON($msgResponse);
            }

            foreach ($participantes as $id) {
                $data = [
                    'id_evento' => $event['id'],
                    'id_modalidad' => $modalidad_id,
                    'id_participante' => $id,
                    'status' => 'NO_ASIGNADO'
                ];

                $this->participantesEventoModel->insert($data);
            }

            $msgResponse['data'] = 'Participantes registrados.';
        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function getParticipantesInEventBySchoolAndMod($id_escuela, $id_mod)
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        try {

            $findStudents = $this->escuelaEstudiantes->where('id_escuela', $id_escuela)->findAll();

            $arrayStudents = [];

            foreach ($findStudents as $student) {
                $find = $this->alumnoModel->select('
                     participantes.id_alumno,
                     participantes.nombres,
                     participantes.apellidos,
                     participantes.edad,
                     participantes.fotografia,
                     participantes.peso,
                     participantes.altura,
                     participantes.sexo,
                     CAT.nom_cat,
                     NIV.descrip_niv,
                     EVENT.status,
                     EVENT.id as id_registro
                    ')
                    ->join('categoria as CAT', 'CAT.id_categoria = participantes.id_categoria')
                    ->join('nivel as NIV', 'NIV.id_nivel = participantes.id_nivel')
                    ->join('evento_participantes as EVENT', 'EVENT.id_participante = participantes.id_alumno')
                    ->where("participantes.id_alumno", $student['id_estudiante'])
                    ->havingIn("participantes.id_alumno", function (BaseBuilder $builder) use ($id_mod) {
                        $id_event = session('event')['id'];
                        return $builder->select('id_participante')->from('evento_participantes')
                            ->where('id_modalidad', $id_mod)
                            ->where('id_evento', $id_event);
                    })->first();

                if ($find) {
                    array_push($arrayStudents, $find);
                }
            }

            $msgResponse['data'] = $arrayStudents;

            return $this->response->setJSON($msgResponse);
        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }

    public function deleteParticipanteEvento($id_registro) 
    {
        $msgResponse = ['status' => 'ok', 'data' => ''];
        try {
            $id_event = session('event')['id'];
            $find = $this->participantesEventoModel->find($id_registro);

            if ($find['status'] === 'ASIGNADO') {
                return $this->response->setJSON(['status' => 'error', 'data' => 'Participante asignado, no se puede eliminar.']);
            }

            $this->participantesEventoModel->delete($id_registro);
            $msgResponse['data'] = 'Registro eliminado correctamente.';
            
        } catch (\Exception $ex) {
            $msgResponse['status'] = 'error';
            $msgResponse['data'] = $ex->getMessage();
        }

        return $this->response->setJSON($msgResponse);
    }
}
