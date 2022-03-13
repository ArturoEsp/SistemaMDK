<?php

namespace App\Models;

use CodeIgniter\Model;

class Nivel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'nivel';
    protected $primaryKey       = 'id_nivel';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['descrip_niv','rango','min_rango','max_rango'];

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

    public function getLevelsByFilter ($age = 0)
    {

        $findLevels = $this->where('min_rango <=', $age)
                                ->where('max_rango >=', $age)
                                ->findAll();
        return $findLevels;
    }
}
