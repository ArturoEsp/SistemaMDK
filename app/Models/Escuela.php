<?php

namespace App\Models;

use CodeIgniter\Model;

class Escuela extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'escuelas';
    protected $primaryKey       = 'id_escuela';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre', 'direccion', 'id_participante'];

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

    public function getSchoolsByTeacher ($id) 
    {
        return $this->where('id_participante', $id)->findAll();
    }
}
