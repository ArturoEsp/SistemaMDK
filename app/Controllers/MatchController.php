<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Area;
use App\Models\Grafica;
use App\Models\Matchs;

class MatchController extends BaseController
{
    private $matchModel;
    private $graficaModel;
    private $areaModel;

    public function __construct()
    {
        $this->matchModel = new Matchs();
        $this->graficaModel = new Grafica();
        $this->areaModel = new Area();
    }

    public function index()
    {
    }

    public function update()
    {
        try {
            $match_id = $this->request->getVar('match_id');

            $update_left_player_id = $this->request->getVar('left_player_id');
            $update_right_player_id = $this->request->getVar('right_player_id');

            $update_left_player_score = (float)$this->request->getVar('left_player_score');
            $update_right_player_score = (float)$this->request->getVar('right_player_score');

            $findMatch = $this->matchModel->find($match_id);
            if (!$findMatch) return $this->response->setJSON(['status' => 'error', 'data' => 'No se encontró el Match']);

            $grafica = $this->graficaModel->find($findMatch['grafica_id']);

            if ($update_left_player_id === 'empty')
                $this->matchModel->update($match_id, ['left_player' => NULL]);
            else if ($update_left_player_id)
                $this->matchModel->update($match_id, ['left_player' => $update_left_player_id]);

            if ($update_right_player_id === 'empty')
                $this->matchModel->update($match_id, ['right_player' => NULL]);
            else if ($update_right_player_id)
                $this->matchModel->update($match_id, ['right_player' => $update_right_player_id]);

            if ((int)$update_left_player_score > 0 && $update_left_player_id !== 'empty')
                $this->matchModel->update($match_id, ['score_left' => $update_left_player_score]);

            if ((int)$update_right_player_score > 0 && $update_right_player_id !== 'empty')
                $this->matchModel->update($match_id, ['score_right' => $update_right_player_score]);

                
            $findMatch = $this->matchModel->find($match_id);
            $areas = $this->areaModel->getAreaByStatus(true);
            $this->matchModel->nextMatch($findMatch, $grafica, $areas);
            return $this->response->setJSON(['status' => 'ok', 'data' => 'Actualización correcta']);

        } catch (\Exception $ex) {
            return $this->response->setJSON(['status' => 'error', 'data' => $ex->getMessage()]);
        }
    }
}
