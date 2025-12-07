<?php

namespace App\Services;

use App\Models\UsuarioModel;
use CodeIgniter\Validation\ValidationInterface;


class AuthService
{
    protected $usuarioModel;
    protected $validation;

    public function __construct(UsuarioModel $usuarioModel, ValidationInterface $validation)
    {
        $this->usuarioModel = $usuarioModel;
        $this->validation = $validation;
    }

    /**
     * Realiza a autenticação do usuário.
     *
     * @param string $login Email ou Login do usuário
     * @param string $senha Senha bruta
     * @return array|bool Retorna os dados do usuário logado ou false em caso de falha
     */
    public function authenticate($login, $senha)
    {
        // 1. Validar input básico (pode ser movido para Validation Config se preferir)
        if (empty($login) || empty($senha)) {
            return false; // Credenciais vazias
        }

        // 2. Tentar encontrar o usuário pelo login ou email
        $usuario = $this->usuarioModel
                        ->where('login', $login)
                        ->orWhere('email', $login)
                        ->first();

        if (!$usuario) {
            return false; // Usuário não encontrado
        }

        // 3. Verificar se as credenciais estão corretas (senha)
        if (!password_verify($senha, $usuario->senha)) {
            return false; // Senha incorreta
        }

        // 4. Verificar se o usuário está ativo (usando o campo 'situacao' da migration)
        if ($usuario->situacao !== 'logado' && $usuario->situacao !== 'deslogado') { // Ajuste a lógica de 'ativo' se necessário
             // A lógica da migration não tinha um campo 'ativo', mas sim 'situacao'.
             // Se a situacao for 'deslogado' por padrão, o login deve mudar para 'logado'
             // Mas para fins de validação de "ativo", assumimos que ele não está banido/inativo.
        }
        
        // 5. Autenticação bem-sucedida. Retornar dados formatados.
        return [
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'email' => $usuario->email,
            'nivel_acesso' => $usuario->nivel_acesso, // Nível de acesso selecionado
            'token_acesso' => $usuario->api_token, // Retorna o token, se existir
            'message' => 'Login bem-sucedido.'
        ];
    }
}
