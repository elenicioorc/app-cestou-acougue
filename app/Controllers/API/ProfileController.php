<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;

class ProfileController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
                $user = $this->request->user ?? null;

        if ($user) {
            return $this->respond([
                'status' => 'success',
                'message' => 'Dados de perfil recuperados com sucesso.',
                'data' => [
                    'nome' => $user->nome,
                    'email' => $user->email,
                    'nivel' => $user->nivel_acesso,
                    'ip_ultimo_login' => $user->last_login_ip,
                ]
            ], 200);
        }

        return $this->failUnauthorized('Falha na autenticação do token.');
    }
}
