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

        $data = [
            'grafica' => $grafica
        ];

        return view('front/graficas/view_grafica', $data);
    }

    public function edit_grafica($id_grafica)
    {
        $grafica = $this->graficaModel
            ->join('nivel', 'nivel.id_nivel = graficas.nivel_id')
            ->join('modalidades', 'modalidades.id_modalidad = graficas.modalidad_id')
            ->find($id_grafica);

        $data = ['grafica' => $grafica];
        
        if ($grafica['editable']) {
            return view('front/graficas/edit_grafica', $data);
        }

        return view('front/graficas/edit_score_grafica', $data);
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

                matchs.left_player,
                matchs.right_player,
                
                matchs.score_right,
                matchs.score_left,
            ')

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


            $data = [
                'no_participantes' => $this->request->getVar('number_participants'),
                'participantes' => $participantes,
                'areas' => $areas
            ];

            $matchs = $this->matchModel->createMatchs($data);
            $no_match = 1;

            if (count($matchs) === 0) {
                return $this->response->setJSON(['status' => 'error', 'data' => 'No se pude generar de manera automática los matchs.']);
            }

            $grafica = $this->graficaModel->insert([
                'nombre' => $this->request->getVar('name'),
                'modalidad_id' => $mod_id,
                'nivel_id' => $nivel_id,
                'evento_id' => $eventoActual['id'],
                'no_participantes' => $this->request->getVar('number_participants'),
            ], true);

            foreach ($matchs as $match) {
                $this->matchModel->insert([
                    'no_match' => $no_match,
                    'id_area' => $match['area'],
                    'left_player' => $match['left_player'],
                    'right_player' => $match['right_player'],
                    'grafica_id' => $grafica,
                ]); 
                $no_match++;
                if ($match['left_player'])
                    $this->participantesEventoModel->update($match['left_player'], ['status' => 'ASIGNADO']);
                
                if ($match['right_player']) 
                    $this->participantesEventoModel->update($match['right_player'], ['status' => 'ASIGNADO']); 
                
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

    public function updateCancel($grafica_id)
    {
        try {
            $find = $this->graficaModel->find($grafica_id);
            if (!$find) return $this->response->setJSON(['status' => 'error', 'data' => 'No se encontró la gráfica.']);

            $matchs = $this->matchModel->where('grafica_id', $grafica_id)->findAll();

            foreach ($matchs as $match) {
                $this->participantesEventoModel->update($match['right_player'], ['status' => 'NO_ASIGNADO']);
                $this->participantesEventoModel->update($match['left_player'], ['status' => 'NO_ASIGNADO']);

                $this->matchModel->delete($match['id']);
            }

            $this->graficaModel->update($grafica_id, ['status' => 'CANCELADO', 'editable' => false]);
            return $this->response->setJSON(['status' => 'ok', 'data' => 'Actualización correcta.']);
        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }

    public function updateSave($grafica_id)
    {
        try {
            $find = $this->graficaModel->find($grafica_id);
            if (!$find) return $this->response->setJSON(['status' => 'error', 'data' => 'No se encontró la gráfica.']);
            
            $this->graficaModel->update($grafica_id, ['editable' => false]);
            return $this->response->setJSON(['status' => 'ok', 'data' => 'Actualización correcta.']);

        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }
}
