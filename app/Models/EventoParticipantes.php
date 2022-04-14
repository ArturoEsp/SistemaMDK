<?php

namespace App\Models;

use CodeIgniter\Model;

class EventoParticipantes extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'evento_participantes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_evento', 'id_modalidad', 'id_participante', 'status'];

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



    public function getIdParticipantesByEvent ($id_event)
    {
        $data = $this->select('id_participante')->where('id_evento', $id_event)->findAll();
        $values = [];
        return $values;
    }

    public function deleteParticipante($modalidad_id, $participante_id, $id_event)
    {
        $this->db->table('evento_participantes')
                ->where('id_modalidad', $modalidad_id)
                ->where('id_participante', $participante_id)
                ->where('id_evento', $id_event)->delete();
    }

    public function findParticipanteByEventMod($modalidad_id, $participante_id, $id_event)
    {
        return $this->db->table('evento_participantes')
                ->where('id_modalidad', $modalidad_id)
                ->where('id_participante', $participante_id)
                ->where('id_evento', $id_event);
    }

    public function getParticipantesForGrafica($evento_id, $mod_id, $nivel_id, $genre)
    {
        $builder = $this->db->table('evento_participantes')
                    ->select('
                        evento_participantes.id as id_registro,
                        participantes.id_alumno as id_alumno,
                        participantes.id_nivel as id_nivel,
                        participantes.altura as altura,
                        participantes.peso as peso,
                        categoria.min_rango,
                        categoria.max_rango,
                        categoria.genero as genero_rango,
                        grados.id_grado,
                    ')
                    ->join('participantes', 'participantes.id_alumno = evento_participantes.id_participante')
                    ->join('categoria', 'participantes.id_categoria = categoria.id_categoria')
                    ->join('grados', 'participantes.id_grado = grados.id_grado')

                    ->where('evento_participantes.id_evento', $evento_id)
                    ->where('evento_participantes.id_modalidad', $mod_id)
                    ->where('evento_participantes.status', 'NO_ASIGNADO')

                    ->where('participantes.id_nivel', $nivel_id);

        if ($genre === 'mens') $builder->where('participantes.sexo', 0);
        if ($genre === 'women') $builder->where('participantes.sexo', 1);

        return $builder->get()->getResultArray();
    }
}
