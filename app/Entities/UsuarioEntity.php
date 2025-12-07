<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class UsuarioEntity extends Entity
{
    // Define os campos (properties) que a Entity gerencia
    protected $attributes = [
        'id'                     => null,
        'nome'                   => null,
        'email'                  => null,
        'documento'              => null,
        'login'                  => null,
        'senha'                  => null,
        'telefone'               => null,
        'situacao'               => 'deslogado',
        'termo_acesso'           => 'N',
        'datetime_recuperacao'   => null,
        'tempo_recuperacao'      => null,
        'token_recuperacao'      => null,
        'cep'                    => null,
        'uf'                     => null,
        'cidade'                 => null,
        'bairro'                 => null,
        'endereco'               => null,
        'foto'                   => null,
        'nivel_acesso'           => 'user',
        'created_at'             => null,
        'updated_at'             => null,
        'deleted_at'             => null,
        'last_login_ip'          => null, // Adicione este novo campo à entidade
    ];

    // Define os tipos de campo (casts) para melhor manipulação
    protected $casts = [
        'id'            => 'integer',
        'tempo_recuperacao' => 'integer',
    ];

    /**
     * Método para capturar e definir o IP atual do usuário.
     * Este é um método utilitário que você chamará no momento do login.
     */
    public function setLastLoginIp()
    {
        $request = \Config\Services::request();
        $this->attributes['last_login_ip'] = $request->getIPAddress();
        return $this;
    }
}
