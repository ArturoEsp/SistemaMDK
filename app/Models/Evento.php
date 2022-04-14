<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use stdClass;

class Evento extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'eventos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre', 'descripcion', 'fecha_inicio',
        'fecha_fin', 'lugar', 'status'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

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

    public function storeData($data, $mods = [])
    {

        $this->db->transStart();

        $this->db->table('eventos')->insert($data);
        $id_evento = $this->db->insertID();

        foreach ($mods as $value) {
            $this->db->table('evento_modalidades')->insert([
                'id_evento' => $id_evento,
                'id_modalidad' => $value
            ]);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === FALSE) {
            return false;
        }

        return true;
    }

    public function eventInProcess()
    {
        $myTime = new Time('now');
        $myTime = $myTime->toDateString();
        $eventFind = $this->where('status', 1)->where('fecha_inicio <=', $myTime)->where('fecha_fin >', $myTime)->first();

        if ($eventFind) {
            $event = new stdClass();
            $event->id = $eventFind['id_evento'];
            $event->nombre = $eventFind['nombre'];
            $event->descripcion = $eventFind['descripcion'];
            $event->fecha_inicio = $eventFind['fecha_inicio'];
            $event->fecha_fin = $eventFind['fecha_fin'];
            $event->lugar = $eventFind['lugar'];
            $event->status = $eventFind['status'];

            $builder = $this->db->table('modalidades');
            $builder->select('*');
            $builder->join('evento_modalidades', 'evento_modalidades.id_modalidad = modalidades.id_modalidad');
            $builder->where('evento_modalidades.id_evento', $eventFind['id_evento']);
            $event->modalidades = $builder->get()->getResult();
            
            return get_object_vars($event);

        } 
        else return false;
    }
}
