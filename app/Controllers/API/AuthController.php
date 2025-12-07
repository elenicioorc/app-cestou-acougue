<?php

namespace App\Controllers\API;

use CodeIgniter\API\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Services\AuthService;
use CodeIgniter\Config\Services; 


class AuthController extends BaseController
{
     protected $authService;
    protected $format = 'json'; // Define o formato de resposta padrão como JSON

    /**
     * Construtor para injeção de dependências.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Inicializa o AuthService com suas dependências (Model e Validation Service)
        $this->authService = new AuthService(
            new \App\Models\UsuarioModel(),
            Services::validation() // Carrega o serviço de validação nativo
        );
    }

    /**
     * Método responsável por processar a requisição de login na API.
     */
    public function login()
    {
        // 1. Verificar o tipo de requisição
        // O CI 4.6.3 não tem um método isAJAX() confiável baseado apenas em cabeçalhos HTTP padrões de API,
        // mas a verificação do método POST é crucial.
        if ($this->request->getMethod() !== 'post') {
            return $this->failUnauthorized('Método de requisição não permitido.', 405);
        }

        // 2. Implementar a classe Validation para verificar os dados POST
        // Regras de validação
        $rules = [
            'login'    => 'required|max_length[255]',
            'senha'    => 'required|min_length[6]', // Ajuste o min_length conforme sua política
        ];

        // Validar a requisição
        if (!$this->validate($rules)) {
            // Retorna erros de validação formatados em JSON
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $login = $this->request->getPost('login');
        $senha = $this->request->getPost('senha');

        // 3. Usar o Serviço de Autenticação para verificar credenciais, status, etc.
        $userData = $this->authService->authenticate($login, $senha);

        if ($userData) {
            // Caso OK: O serviço retornou os dados do usuário e o nível de acesso
            
            // Opcional: Atualizar o IP do último login e a situação (logado)
            // Isso requer carregar a model novamente ou ajustar o AuthService para fazer isso.
            
            return $this->respond($userData, 200); // Retorna 200 OK com os dados do usuário
        } else {
            // Caso falhe: Credenciais inválidas ou usuário inativo
            return $this->failUnauthorized('Credenciais inválidas ou usuário inativo.'); // Retorna 401 Unauthorized
        }
    }
}
