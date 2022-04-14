<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Area;
use App\Models\Evento;
use App\Models\EventoModalidades;
use App\Models\EventoParticipantes;
use App\Models\Grafica;
use App\Models\Matchs;
use App\Models\Nivel;
use App\Models\Participante;

class GraficaController extends BaseController
{
    private $graficaModel;
    private $matchModel;
    private $participanteModel;
    private $participantesEventoModel;
    private $eventoModel;
    private $areaModel;
    private $modalidadesEventoModel;
    private $nivelModel;

    public function __construct()
    {
        $this->graficaModel = new Grafica();
        $this->matchModel = new Matchs();
        $this->participanteModel = new Participante();
        $this->participantesEventoModel = new EventoParticipantes();
        $this->eventoModel = new Evento();
        $this->areaModel = new Area();
        $this->modalidadesEventoModel = new EventoModalidades();
        $this->nivelModel = new Nivel();
    }

    public function index()
    {
        return view('front/graficas/graficas');
    }

    public function view_grafica($id_grafica) 
    {
        $grafica = $this->graficaModel->find($id_grafica);
        $matchs = $this->matchModel
            ->select('
                matchs.no_match as no_match,
                PART.nombres as right_player_nombre,
                PART2.nombres as left_player_nombre,

                matchs.score_right as right_player_score,
                matchs.score_left as left_player_score,
            ')
            ->join('evento_participantes as EV', 'EV.id = matchs.right_player')
            ->join('evento_participantes as EV2', 'EV2.id = matchs.left_player')

            ->join('participantes as PART', 'PART.id_alumno = EV.id_participante')
            ->join('participantes as PART2', 'PART2.id_alumno = EV2.id_participante')
            
            ->where('grafica_id', $id_grafica)
            ->orderBy('matchs.no_match', 'ASC')
            ->findAll();

        $data = [
            'grafica' => $grafica,
            'matchs' => $matchs
        ];

        return view('front/graficas/view_grafica', $data);
    }

    public function edit_grafica($id_grafica)
    {
        $grafica = $this->graficaModel->find($id_grafica);
        $data = [
            'grafica' => $grafica
        ];
        return view('front/graficas/edit_grafica', $data);
    }

    public function getGraficaMatchs($id_grafica)
    {
        try {
            $matchs = $this->matchModel
            ->select('
                matchs.id as match_id,
                matchs.no_match as no_match,
                AREAS.nombre as nombre_area,
                GRAFICA.no_participantes,

                EV.id as right_player_registro_id,
                EV2.id as left_player_registro_id,
                
                PART.nombres as right_player_nombre,
                PART2.nombres as left_player_nombre,

                PART.apellidos as right_player_apellidos,
                PART2.apellidos as left_player_apellidos,
    
                matchs.score_right as right_player_score,
                matchs.score_left as left_player_score,
            ')
            ->join('evento_participantes as EV', 'EV.id = matchs.right_player')
            ->join('evento_participantes as EV2', 'EV2.id = matchs.left_player')
    
            ->join('participantes as PART', 'PART.id_alumno = EV.id_participante')
            ->join('participantes as PART2', 'PART2.id_alumno = EV2.id_participante')

            ->join('areas as AREAS', 'AREAS.id_area = matchs.id_area')
            ->join('graficas as GRAFICA', 'GRAFICA.id = matchs.grafica_id')
    
            ->where('grafica_id', $id_grafica)
            ->orderBy('matchs.no_match', 'ASC')
            ->findAll();

            return $this->response->setJSON(['status' => 'ok', 'data' =>  $matchs]);
        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }

    public function create_grafica()
    {
        $evento = session('event');
        if (!$evento) return redirect()->to('/');

        $modalidadesEvento = $this->modalidadesEventoModel
            ->join('modalidades', 'modalidades.id_modalidad = evento_modalidades.id_modalidad')
            ->where('id_evento', $evento['id'])->findAll();
  
        $niveles = $this->nivelModel->findAll();

        $data = [
            'modalidades' => $modalidadesEvento,
            'niveles' => $niveles
        ];
        return view('front/graficas/crear_grafica', $data);
    }

    public function getParticipantesForParams() 
    {
        try {

            $evento_id = session('event')['id'];
            $mod_id = $this->request->getVar('mod_id');
            $nivel_id = $this->request->getVar('nivel_id');
            $genre = $this->request->getVar('genre');

            $participantes = $this->participantesEventoModel->getParticipantesForGrafica($evento_id, $mod_id, $nivel_id, $genre);
            return $this->response->setJSON(['status' => 'ok', 'data' => $participantes]);

        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }

    public function store()
    {
        try {

            $eventoActual = $this->eventoModel->eventInProcess();
            if (!$eventoActual) return $this->response->setJSON(['status' => 'error', 'data' => 'No hay un evento en proceso.']);

            $evento_id = session('event')['id'];
            $mod_id = $this->request->getVar('mod_id');
            $nivel_id = $this->request->getVar('nivel_id');
            $genre = $this->request->getVar('genre');

            $participantes = $this->participantesEventoModel->getParticipantesForGrafica($evento_id, $mod_id, $nivel_id, $genre);
            $areas = $this->areaModel->getAreaByStatus(true);

            if (!$participantes) return $this->response->setJSON(['status' => 'error', 'data' => 'No hay participantes disponibles.']);
            if (!$areas) return $this->response->setJSON(['status' => 'error', 'data' => 'No hay areas disponibles para crear matchs.']);

            $grafica = $this->graficaModel->insert([
                'nombre' => $this->request->getVar('name'),
                'modalidad_id' => $mod_id,
                'nivel_id' => $nivel_id,
                'evento_id' => $eventoActual['id'],
                'no_participantes' => $this->request->getVar('number_participants'),
            ], true);

            $data = [
                'no_participantes' => $this->request->getVar('number_participants'),
                'participantes' => $participantes,
                'areas' => $areas
            ];

            $matchs = $this->matchModel->createMatchs($data);
            $no_match = 1;
            foreach ($matchs as $match) {
                $this->matchModel->insert([
                    'no_match' => $no_match,
                    'id_area' => $match['area'],
                    'left_player' => $match['left_player'],
                    'right_player' => $match['right_player'],
                    'grafica_id' => $grafica,
                ]);

                $no_match++;
            }

            return $this->response->setJSON(['status' => 'ok', 'data' => 'Grafica creada correctamente.']);

        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }

    public function update () 
    {
        try {

        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }
}
