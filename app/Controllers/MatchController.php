<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Area;
use App\Models\EventoParticipantes;
use App\Models\Grafica;
use App\Models\Matchs;

class MatchController extends BaseController
{
    private $matchModel;
    private $graficaModel;
    private $areaModel;
    private $eventoParticipantesModel;

    public function __construct()
    {
        $this->matchModel = new Matchs();
        $this->graficaModel = new Grafica();
        $this->areaModel = new Area();
        $this->eventoParticipantesModel = new EventoParticipantes();
    }

    public function index()
    {
    }

    public function changeMatch() 
    {
        try {

            $match_id = $this->request->getVar('match_id');
            $findMatch = $this->matchModel->find($match_id);
            if (!$findMatch) 
                return $this->response->setJSON(['status' => 'error', 'data' => 'No se encontró el Match']);

            $findGrafica = $this->graficaModel->find($findMatch['grafica_id']);
            if ($findGrafica['editable'] === '0') 
                return $this->response->setJSON(['status' => 'error', 'data' => 'La gráfica ya no permite actualizar los matchs.']);

            $update_left_player_id = $this->request->getVar('left_player_id');
            $update_right_player_id = $this->request->getVar('right_player_id');

            if ($update_left_player_id === $update_right_player_id)
                return $this->response->setJSON(['status' => 'error', 'data' => 'Participante repetido en el mismo match.']);

            if ($update_left_player_id === 'empty') {
                $this->matchModel->update($match_id, ['left_player' => NULL]);
            } else if ($update_left_player_id) {
                $left_player = $findMatch['left_player'];
                $this->eventoParticipantesModel->update($left_player, ['status' => 'NO_ASIGNADO']);
                $this->eventoParticipantesModel->update($update_left_player_id, ['status' => 'ASIGNADO']);
                $this->matchModel->update($match_id, ['left_player' => $update_left_player_id]);
            }

            if ($update_right_player_id === 'empty') {
                $this->matchModel->update($match_id, ['right_player' => NULL]);
            } else if ($update_right_player_id) {
                $right_player = $findMatch['right_player'];
                $this->eventoParticipantesModel->update($right_player, ['status' => 'NO_ASIGNADO']);
                $this->eventoParticipantesModel->update($update_right_player_id, ['status' => 'ASIGNADO']);
                $this->matchModel->update($match_id, ['right_player' => $update_right_player_id]);
            }
                
            return $this->response->setJSON(['status' => 'ok', 'data' => 'Actualización correcta.']);
            
        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }

    public function update()
    {
        try {
            $match_id = $this->request->getVar('match_id');
            $update_left_player_id = $this->request->getVar('left_player_id');
            $update_right_player_id = $this->request->getVar('right_player_id');

            $findMatch = $this->matchModel->find($match_id);
            if (!$findMatch) return $this->response->setJSON(['status' => 'error', 'data' => 'No se encontró el Match']);

            // Verificación de que no exista repetido el participante dentro del Match.
            if ($update_left_player_id === $update_right_player_id) return $this->response->setJSON(['status' => 'error', 'data' => 'El participante esta duplicado en el match.']);

            // Verificación de que el participante no este duplicado en el Match.
            $matchs = $this->matchModel->where('grafica_id', $findMatch['grafica_id'])->findAll();

            foreach ($matchs as $match) {
                if ($match['id'] !== $match_id) {
                    if ($match['left_player'] === $update_left_player_id || $match['right_player'] === $update_left_player_id)
                        return $this->response->setJSON(['status' => 'error', 'data' => 'Existen participantes duplicados en esta gráfica.']);
                        
                    if ($match['left_player'] === $update_right_player_id || $match['right_player'] === $update_right_player_id)
                        return $this->response->setJSON(['status' => 'error', 'data' => 'Existen participantes duplicados en esta gráfica.']);
                }
            }

            if ($update_left_player_id === 'empty') {

                $beforePlayer = $findMatch['left_player'];
                if ($beforePlayer) {
                    $this->eventoParticipantesModel->update($beforePlayer, ['status' => 'NO_ASIGNADO']);
                }

                $this->matchModel->update($match_id, ['left_player' => NULL]);
            } else {
                $findParticipanteInEvent = $this->eventoParticipantesModel->find($update_left_player_id);
                if ($findMatch['left_player'] !== $update_left_player_id) {
                    if ($findParticipanteInEvent['status'] === 'NO_ASIGNADO') {

                        $beforePlayer = $findMatch['left_player'];
                        if ($beforePlayer) {
                            $this->eventoParticipantesModel->update($beforePlayer, ['status' => 'NO_ASIGNADO']);
                        }

                        $this->eventoParticipantesModel->update($update_left_player_id, ['status' => 'ASIGNADO']);
                        $this->matchModel->update($match_id, ['left_player' => $update_left_player_id]);
                    }
    
                    if ($findParticipanteInEvent['status'] === 'ASIGNADO') 
                        return $this->response->setJSON(['status' => 'error', 'data' => 'Existen participantes que ya están dentro de otra grafica 1.']);
                }
            }

            if ($update_right_player_id === 'empty') {

                $beforePlayer = $findMatch['right_player'];
                if ($beforePlayer) {
                    $this->eventoParticipantesModel->update($beforePlayer, ['status' => 'NO_ASIGNADO']);
                }

                $this->matchModel->update($match_id, ['right_player' => NULL]);
            } else {

                $findParticipanteInEvent = $this->eventoParticipantesModel->find($update_right_player_id);
                if ($findMatch['right_player'] !== $update_right_player_id) {
                    if ($findParticipanteInEvent['status'] === 'NO_ASIGNADO') {

                        $beforePlayer = $findMatch['right_player'];
                        if ($beforePlayer) {
                            $this->eventoParticipantesModel->update($beforePlayer, ['status' => 'NO_ASIGNADO']);
                        }

                        $this->eventoParticipantesModel->update($update_right_player_id, ['status' => 'ASIGNADO']);
                        $this->matchModel->update($match_id, ['right_player' => $update_right_player_id]);
                    }
    
                    if ($findParticipanteInEvent['status'] === 'ASIGNADO') 
                        return $this->response->setJSON(['status' => 'error', 'data' => 'Existen participantes que ya están dentro de otra grafica 2.']);
                }

            }
                
            return $this->response->setJSON(['status' => 'ok', 'data' => 'Actualización correcta']);

        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }

    public function saveScores () 
    {
        try {
            $match_id = $this->request->getVar('match_id');
            $score_left_player = $this->request->getVar('left_player_score');
            $score_right_player = $this->request->getVar('right_player_score');

            $findMatch = $this->matchModel->find($match_id);
            if (!$findMatch) return $this->response->setJSON(['status' => 'error', 'data' => 'No se encontró el Match']);

            if ($findMatch['score_left'] && $findMatch['score_right']) return $this->response->setJSON(['status' => 'error', 'data' => 'Este match ya tiene puntuación.']);

            $this->matchModel->update($match_id, ['score_left' => $score_left_player, 'score_right' => $score_right_player]);


            $findGrafica = $this->graficaModel->find($findMatch['grafica_id']);
            $findMatch = $this->matchModel->find($match_id);
            $areas = $this->areaModel->getAreaByStatus(true);

            $this->matchModel->nextMatch($findMatch, $findGrafica, $areas);

            return $this->response->setJSON(['status' => 'ok', 'data' => 'Actualización correcta.']);
        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }
}
