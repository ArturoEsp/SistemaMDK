<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\TipoUsuario;
use App\Models\Participante;

class UserController extends BaseController
{

    public function index()
    {
        $modelParticipante = new Participante();
        $modelTipoUsuario = new TipoUsuario();

        $tipos_usuario = $modelTipoUsuario->findAll();
        $allUsers = [];

        foreach ($tipos_usuario as $type) {
            $users = $modelParticipante->where('id_tu', $type['id_tu'])->findAll();

            foreach ($users as $user) {
                array_push($allUsers, $user);
            }
        }

        $data = [
            'tipos_usuario' => $tipos_usuario,
            'usuarios' => $allUsers,
        ];

        return view('front/users/users', $data);
    }

    public function create()
    {
        $tipos_usuarios = new TipoUsuario();

        $data = [
            'tipos_usuario' => $tipos_usuarios->findAll()
        ];

        return view('front/users/create_user', $data);
    }

    public function store()
    {
        $user = new Participante();
        $data = [
            'nombres' => $this->request->getVar('name'),
            'apellidos' => $this->request->getVar('lastname'),
            'usuario' => $this->request->getVar('username'),
            'contrasena' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'id_tu' => $this->request->getVar('type_user'),
        ];

        $user->save($data);
        return redirect()->to('/users');
    }

    public function findUsersByParams()
    {
        $responseData = [];

        $keyWords = $this->request->getVar("keyWords");
        $type_user = $this->request->getVar("type_user");

        $modelParticipante = new Participante();
        $responseData = $modelParticipante->findLikeParticipantes($keyWords, $type_user);

        return $this->response->setJSON($responseData);
    }

    public function deleteUserById()
    {
        $modelParticipante = new Participante();
        $responseMsg = ['status' => 'ok', '' => 'Usuario eliminado correctamente.'];

        $id = $this->request->getVar('id');

        $find = $modelParticipante->where('id_alumno', $id)->findAll();

        if (!$find)
            $responseMsg = ['status' => 'error', '' => 'Usuario no encontrado.'];

        $modelParticipante->where('id_alumno', $id)->delete();

        return $this->response->setJSON($responseMsg);
    }

    public function updateUserById($id)
    {
        $modelParticipante = new Participante();
        $dataUpdate = [];

        if ($this->request->getVar('name'))
            $dataUpdate['nombres'] = $this->request->getVar('name');


        if ($this->request->getVar('lastname'))
            $dataUpdate['apellidos'] = $this->request->getVar('lastname');


        if ($this->request->getVar('username'))
            $dataUpdate['usuario'] = $this->request->getVar('username');

        if ($this->request->getVar('password') && strlen($this->request->getVar('password')) > 0)
            $dataUpdate['contrasena'] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);

        if ($this->request->getVar('type_user'))
            $dataUpdate['id_tu'] = $this->request->getVar('type_user');


        if ($modelParticipante->update($id, $dataUpdate))
            return $this->response->setJSON(['status' => 'ok', 'data' => 'Actualización correcta.']);
        
        return $this->response->setJSON(['status' => 'error', 'data' => 'Ocurrió un error al actualizar los datos, intentalo de nuevo.']);
    }

    public function getUserById($id)
    {
        $modelParticipante = new Participante();
        $find = $modelParticipante->where('id_alumno', $id)->first();
        $responseMsg = ['status' => 'ok', 'data' => $find];

        return $this->response->setJSON($responseMsg);
    }
}
