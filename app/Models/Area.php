<?php

namespace App\Models;

use CodeIgniter\Model;

class Area extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'areas';
    protected $primaryKey       = 'id_area';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nombre','status'];

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


    public function getAreaByStatus ($status = null)
    {
        $response = [];

        if ($status === true || $status === false) 
            $this->where("status", $status);
  
        $query = $this->get();
    
        if($query->getResultArray())
            $response = $query->getResultArray();
        
        return $response;
    }   
}
