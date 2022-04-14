<?php

namespace App\Models;

use CodeIgniter\Model;
use PhpParser\Node\Expr\Cast\Double;

class Matchs extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'matchs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'no_match', 'id_area', 'left_player', 'right_player',
        'score_left', 'score_right', 'grafica_id'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function createMatchs($data)
    {
        $areas = $data['areas'];
        $no_participantes = (int)$data['no_participantes'];
        $participantes = $data['participantes'];
        $matchs = [];
        $total_areas = count($areas);

        $default_altura = 10;

        foreach ($participantes as $left_player) {
            foreach ($participantes as $right_player) {
                $diff_altura = abs((int)$left_player['altura'] - (int)$right_player['altura']);
                $diff_grado = abs((int)$left_player['id_grado'] - (int)$right_player['id_grado']);

                if (
                    (float)$left_player['peso'] >= (float)$right_player['min_rango'] &&
                    (float)$left_player['peso'] <= (float)$right_player['max_rango']
                ) {
                    if (
                        $diff_altura <= $default_altura &&
                        $left_player['id_registro'] !== $right_player['id_registro'] && $diff_grado <= 2
                    ) {

                        $data = [
                            "left_player" => $left_player['id_registro'],
                            "right_player" => $right_player['id_registro'],
                            "area" => $areas[rand(1, $total_areas)]['id_area']
                        ];

                        $exist = $this->existParticipantesInMatch($matchs, $data);

                        if ($no_participantes !== (count($matchs) * 2) && !$exist) {
                            array_push($matchs, $data);
                            break;
                        }
                    }
                }
            }
        }


        return $matchs;
    }

    private function existParticipantesInMatch($matchs = [], $data = [])
    {
        foreach ($matchs as $match) {
            if (
                $match['left_player'] === $data['left_player'] || $match['right_player'] === $data['right_player'] ||
                $match['left_player'] === $data['right_player'] || $match['right_player'] === $data['left_player']
            )
                return true;
        }

        return false;
    }

    private function nextSegmentMatch($no_participantes, $no_match)
    {
        switch ($no_participantes) {
            case 4: {
                    if ($no_match === 1) return 3;
                    if ($no_match === 2) return 3;
                }
            case 8: {
                    if ($no_match === 1) return 5;
                    if ($no_match === 2) return 5;

                    if ($no_match === 3) return 6;
                    if ($no_match === 4) return 6;

                    if ($no_match === 5) return 7;
                    if ($no_match === 6) return 7;
                }
            case 16: {

                    if ($no_match === 1) return 9;
                    if ($no_match === 2) return 9;

                    if ($no_match === 3) return 10;
                    if ($no_match === 4) return 10;

                    if ($no_match === 5) return 11;
                    if ($no_match === 6) return 11;

                    if ($no_match === 7) return 12;
                    if ($no_match === 8) return 12;

                    if ($no_match === 9) return 13;
                    if ($no_match === 10) return 13;

                    if ($no_match === 11) return 14;
                    if ($no_match === 12) return 14;

                    if ($no_match === 13) return 15;
                    if ($no_match === 14) return 15;
                }
        }
    }

    public function nextMatch($findMatch, $grafica, $areas)
    {

        $score_left = (float)$findMatch['score_left'];
        $score_right = (float)$findMatch['score_right'];

        $player_left = $findMatch['left_player'];
        $player_right = $findMatch['right_player'];

        $no_match = (int)$findMatch['no_match'];
        $no_participantes = (int)$grafica['no_participantes'];
        $total_areas = count($areas);
        $id_area = $areas[rand(1, $total_areas)]['id_area'];

        error_log("count: $total_areas");
        error_log("area: $id_area");

        if ($score_left > 0 && $score_right > 0) {

            $winner = ($score_left > $score_right) ? $player_left :  $player_right;
            $next_match = $this->nextSegmentMatch($no_participantes, $no_match);

            $findMatchWithNumber = $this->where('no_match', $next_match)->first();

            if (!$findMatchWithNumber) {
                $this->insert([
                    'no_match' => $next_match,
                    'id_area' => $id_area,
                    'left_player' => $winner,
                    'grafica_id' => $grafica['id'],
                ]);
            } else {
                error_log('Si existe el match con numer');
                if ($findMatchWithNumber['left_player'] === NULL) {
                    $this->update($findMatchWithNumber['id'], ['left_player' => $winner]);
                }
                
                if ($findMatchWithNumber['right_player'] === NULL) {
                    $this->update($findMatchWithNumber['id'], ['right_player' => $winner]);
                }
                
            }
        } 
    }

}
