<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Database\Seeds\TiposUsuario;
use App\Models\Evento;
use App\Models\Participante;
use App\Models\TipoUsuario;

class AuthController extends BaseController
{
    private $eventoModel;

    public function __construct()
    {
        $this->eventoModel = new Evento();
    }

    public function index()
    {
        return view('front/auth/login');
    }

    public function dashboard()
    {
        return view('front/dashboard');
    }

    public function login ()
    {
        $session = session();
        $userModel = new Participante();
        $typeUserModel = new TipoUsuario();

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $find = $userModel->where('usuario', $username)->first();
        $event = $this->eventoModel->eventInProcess();

        if ($find) {
            $pass = $find['contrasena'];
            $pass_verify = password_verify($password, $pass);

            if ($pass_verify) {
                $session_data = [
                    'idUser' => $find['id_alumno'],
                    'nameUser' => $find['nombres'],
                    'isSignedIn' => TRUE
                ];

                
                $typeUser = $typeUserModel->where('id_tu', $find['id_tu'])->first();
                $menuRol = $userModel->setMenuRol($typeUser['tu_descrip']);
                
                $session->set(['menu' => $menuRol, 
                'data_user' => $session_data, 
                'event' => $event]);
                
                return redirect()->to('/');

            } else {
                $session->setFlashdata('msg', 'Contraseña incorrecta.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'No se encontró este usuario.');
            return redirect()->to('/login');
        }
    }

    public function logout ()
    {
        $session = session();
        $session->remove('data_user');
        $session->remove('menu');
        $session->remove('event');

        return redirect()->to('/');
    }
}
