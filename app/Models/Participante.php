<?php

namespace App\Models;

use CodeIgniter\Model;
use phpDocumentor\Reflection\Types\Null_;

class Participante extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'participantes';
    protected $primaryKey       = 'id_alumno';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'usuario',
                                    'contrasena',
                                    'nombres',
                                    'apellidos',
                                    'sexo',
                                    'edad',
                                    'altura',
                                    'peso',
                                    'fotografia',
                                    'id_tu',
                                    'id_ta',
                                    'id_categoria',
                                    'id_nivel'];

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

    public function findLikeParticipantes ($keyWords = null, $type_user = null )
    {
        $response = [];

        if ($keyWords && strlen($keyWords) > 0) {
            $this->like("nombres", $keyWords, 'both');
            $this->orLike("apellidos", $keyWords, 'both');
            $this->orLike("usuario", $keyWords, 'both'); 

        }

        if ($type_user && strlen($type_user) > 0) $this->where("id_tu", $type_user);

        $this->where("usuario !=", null);
        $this->orderBy("nombres", "ASC");  
        $query = $this->get();

        if($query->getResultArray())
            $response = $query->getResultArray();
        
        return $response;
    }

    public function setMenuRol ($type_user = null) {
        $rules = [
            'usuarios'      => true,
            'escuelas'      => true,
            'participantes' => true,
            'areas'         => true,
            'graficas'      => true,
            'eventos'       => true,
            'pase_lista'    => true
        ];

        switch ($type_user) {
            case 'Administrador': return $rules;
            case 'Director': return $rules;
            case 'Maestro': 
                $rules['usuarios'] = false;
                $rules['escuelas'] = false;
                $rules['areas'] = false;
                $rules['graficas'] = false;
                $rules['eventos'] = false;
                $rules['pase_lista'] = false;
                break;
            case 'Recepción':
                $rules['usuarios'] = false;
                $rules['escuelas'] = false;
                $rules['areas'] = false;
                $rules['graficas'] = false;
                $rules['eventos'] = false;
                $rules['participantes'] = false;
                break;
            case 'Sistema':
                $rules['usuarios'] = false;
                $rules['escuelas'] = false;
                $rules['areas'] = false;
                $rules['eventos'] = false;
                $rules['pase_lista'] = false;
                break;
            case 'Director de área':
                $rules['usuarios'] = false;
                $rules['escuelas'] = false;
                $rules['eventos'] = false;
                $rules['pase_lista'] = false;
                $rules['participantes'] = false;
                break;
            case 'Encargado de área':
                $rules['usuarios'] = false;
                $rules['escuelas'] = false;
                $rules['eventos'] = false;
                $rules['pase_lista'] = false;
                $rules['participantes'] = false;
                break;
        }

        return $rules;
    }

}
