<?php

namespace App\Models;

use CodeIgniter\Model;

class Categoria extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categoria';
    protected $primaryKey       = 'id_categoria';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nom_cat', 'rango', 'min_rango', 'max_rango','genero'];

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

    public function getCategoriesByFilter ($weight = 0, $genre = 0)
    {
        $filterGenre = $genre == 0 ? 'Varonil' : 'Femenil';

        $findCategories = $this->where('genero', $filterGenre)
                                ->where('min_rango <=', $weight)
                                ->where('max_rango >=', $weight)
                                ->findAll();
        return $findCategories;
    }
}
