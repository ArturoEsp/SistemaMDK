<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Categorias extends Seeder
{
    public function run()
    {
        $data = [
            ['nom_cat' => 'Catarina', 'rango' => '< 17kg', 'min_rango' => 0 , 'max_rango' => 17, 'genero' => 'Femenil'],
            ['nom_cat' => 'Luciérnaga', 'rango' => '17.1-20 kg', 'min_rango' => 17.1 , 'max_rango' => 20, 'genero' => 'Femenil'],
            ['nom_cat' => 'Abeja', 'rango' => '20.1-23 kg', 'min_rango' => 20.1, 'max_rango' => 23, 'genero' => 'Femenil'],
            ['nom_cat' => 'Avispa', 'rango' => '23.1-26 kg', 'min_rango' => 23.1, 'max_rango' => 26, 'genero' => 'Femenil'],
            ['nom_cat' => 'Mariposa', 'rango' => '26.1-29 kg', 'min_rango' => 26.1, 'max_rango' => 29, 'genero' => 'Femenil'],
            ['nom_cat' => 'Libélula', 'rango' => '29.1-33 kg', 'min_rango' => 29.1, 'max_rango' => 33, 'genero' => 'Femenil'],
            ['nom_cat' => 'Golondrina', 'rango' => '33.1-37 kg', 'min_rango' => 33.1, 'max_rango' => 37, 'genero' => 'Femenil'],
            ['nom_cat' => 'Paloma', 'rango' => '37.1-41 kg', 'min_rango' => 37.1, 'max_rango' => 41, 'genero' => 'Femenil'],
            ['nom_cat' => 'Gaviota ', 'rango' => '41.1-45 kg', 'min_rango' => 41.1, 'max_rango' => 45, 'genero' => 'Femenil'],
            ['nom_cat' => 'Águila', 'rango' => '>45 kg', 'min_rango' => 45, 'max_rango' => 1000, 'genero' => 'Femenil'],
            ['nom_cat' => 'Búho', 'rango' => '<17 kg', 'min_rango' => 0, 'max_rango' => 17, 'genero' => 'Varonil'],
            ['nom_cat' => 'Gallo', 'rango' => '17.1-19 kg', 'min_rango' => 17.1, 'max_rango' => 19, 'genero' => 'Varonil'],
            ['nom_cat' => 'Halcón', 'rango' => '19.1-21 kg', 'min_rango' => 19.1, 'max_rango' => 21, 'genero' => 'Varonil'],
            ['nom_cat' => 'Condor', 'rango' => '21.1-24 kg', 'min_rango' => 21.1, 'max_rango' => 24, 'genero' => 'Varonil'],
            ['nom_cat' => 'Gato Montés', 'rango' => '24.1-27 kg', 'min_rango' => 24.1, 'max_rango' => 27, 'genero' => 'Varonil'],
            ['nom_cat' => 'Ocelote', 'rango' => '27.1-30 kg', 'min_rango' => 27.1, 'max_rango' => 30, 'genero' => 'Varonil'],
            ['nom_cat' => 'Lince', 'rango' => '30.1-33 kg', 'min_rango' => 30.1, 'max_rango' => 33, 'genero' => 'Varonil'],
            ['nom_cat' => 'Leopardo', 'rango' => '33.1-36 kg', 'min_rango' => 33.1, 'max_rango' => 36, 'genero' => 'Varonil'],
            ['nom_cat' => 'Puma', 'rango' => '36.1-39 kg', 'min_rango' => 36.1, 'max_rango' => 39, 'genero' => 'Varonil'],
            ['nom_cat' => 'Pantera', 'rango' => '39.1-42 kg', 'min_rango' => 39.1, 'max_rango' => 42, 'genero' => 'Varonil'],
            ['nom_cat' => 'Jaguar', 'rango' => '42.1-46 kg', 'min_rango' => 42.1, 'max_rango' => 46, 'genero' => 'Varonil'],
            ['nom_cat' => 'Chita', 'rango' => '46.1-50 kg', 'min_rango' => 46.1, 'max_rango' => 50, 'genero' => 'Varonil'],
            ['nom_cat' => 'Tigre', 'rango' => '50.1-54 kg', 'min_rango' => 50.1, 'max_rango' => 54, 'genero' => 'Varonil'],
            ['nom_cat' => 'León', 'rango' => '>54 kg', 'min_rango' => 54, 'max_rango' => 1000, 'genero' => 'Varonil'],
            ['nom_cat' => 'Finn', 'rango' => '<46 kg', 'min_rango' => 0, 'max_rango' => 46, 'genero' => 'Femenil'],
            ['nom_cat' => 'Fly', 'rango' => '46.1-49 kg', 'min_rango' => 46.1, 'max_rango' => 49, 'genero' => 'Femenil'],
            ['nom_cat' => 'Bantham', 'rango' => '49.1-53 kg', 'min_rango' => 49.1, 'max_rango' =>53, 'genero' => 'Femenil'],
            ['nom_cat' => 'Feather', 'rango' => '53.1-57 kg', 'min_rango' => 53.1, 'max_rango' => 57, 'genero' => 'Femenil'],
            ['nom_cat' => 'Ligth', 'rango' => '57.1-62 kg', 'min_rango' => 57.1, 'max_rango' => 62, 'genero' => 'Femenil'],
            ['nom_cat' => 'Welter', 'rango' => '62.1-67 kg', 'min_rango' => 62.1, 'max_rango' => 67, 'genero' => 'Femenil'],
            ['nom_cat' => 'Middle', 'rango' => '67.1-73 kg', 'min_rango' => 67.1, 'max_rango' => 73, 'genero' => 'Femenil'],
            ['nom_cat' => 'Heavy', 'rango' => '>73 kg', 'min_rango' => 73, 'max_rango' => 1000, 'genero' => 'Femenil'],
            ['nom_cat' => 'Finn', 'rango' => '<54 kg', 'min_rango' => 0, 'max_rango' => 54, 'genero' => 'Varonil'],
            ['nom_cat' => 'Fly', 'rango' => '54.1-58 kg', 'min_rango' => 54.1, 'max_rango' => 58, 'genero' => 'Varonil'],
            ['nom_cat' => 'Bantham', 'rango' => '58.1-63 kg', 'min_rango' => 58.1, 'max_rango' => 63, 'genero' => 'Varonil'],
            ['nom_cat' => 'Feather', 'rango' => '63.1-68 kg', 'min_rango' => 63.1, 'max_rango' => 68, 'genero' => 'Varonil'],
            ['nom_cat' => 'Ligth', 'rango' => '68.1-74 kg', 'min_rango' => 68.1, 'max_rango' => 74, 'genero' => 'Varonil'],
            ['nom_cat' => 'Welter', 'rango' => '74.1-80 kg', 'min_rango' => 74.1, 'max_rango' => 80, 'genero' => 'Varonil'],
            ['nom_cat' => 'Middle', 'rango' => '80.1-87 kg', 'min_rango' => 80.1, 'max_rango' => 87, 'genero' => 'Varonil'],
            ['nom_cat' => 'Heavy', 'rango' => '> 87 kg', 'min_rango' => 87, 'max_rango' => 1000, 'genero' => 'Varonil'],

        ];

        // Using Query Builder
        $this->db->table('categoria')->insertBatch($data);
    }
}
