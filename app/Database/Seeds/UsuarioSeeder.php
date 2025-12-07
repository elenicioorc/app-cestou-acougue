<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Senha para ambos os usuários neste exemplo: 'senha123'
        $senhaHash = password_hash('senha123', PASSWORD_DEFAULT);
        $currentTime = Time::now()->toDateTimeString();

        $data = [
            [
                'nome'                 => 'Administrador Master',
                'email'                => 'admin@example.com',
                'documento'            => '11122233344',
                'login'                => 'admin_master',
                'senha'                => $senhaHash,
                'telefone'             => '7499887766',
                'situacao'             => 'deslogado',
                'termo_acesso'         => 'Y',
                // Campos NOT NULL obrigatórios da migration original
                'datetime_recuperacao' => $currentTime, 
                'tempo_recuperacao'    => 0, // Assumindo 0 ou outro valor inicial INT
                'token_recuperacao'    => 'token_admin_inicial_recup', 
                //
                'cep'                  => '48970000',
                'uf'                   => 'BA',
                'cidade'               => 'Sr. do Bonfim',
                'bairro'               => 'Centro',
                'endereco'             => 'Rua Principal, 100',
                'foto'                 => 'caminho/para/foto/admin.jpg', // Campo NOT NULL TEXT
                'nivel_acesso'         => 'admin',
                // Novos campos adicionados posteriormente via SQL
                'last_login_ip'        => null, 
                'api_token'            => 'token_admin_inicial', // Token usado no Postman
                // Timestamps do Model
                'created_at'           => $currentTime,
                'updated_at'           => $currentTime,
            ],
            [
                'nome'                 => 'Usuario Comum',
                'email'                => 'user@example.com',
                'documento'            => '55566677788',
                'login'                => 'user_comum',
                'senha'                => $senhaHash,
                'telefone'             => '7491234567',
                'situacao'             => 'deslogado',
                'termo_acesso'         => 'N',
                 // Campos NOT NULL obrigatórios da migration original
                'datetime_recuperacao' => $currentTime,
                'tempo_recuperacao'    => 0,
                'token_recuperacao'    => 'token_user_inicial_recup',
                //
                'cep'                  => '48970000',
                'uf'                   => 'BA',
                'cidade'               => 'Sr. do Bonfim',
                'bairro'               => 'Novo',
                'endereco'             => 'Rua Secundária, 50',
                'foto'                 => 'caminho/para/foto/user.jpg', // Campo NOT NULL TEXT
                'nivel_acesso'         => 'user',
                 // Novos campos adicionados posteriormente via SQL
                'last_login_ip'        => null,
                'api_token'            => 'token_user_comum',
                // Timestamps do Model
                'created_at'           => $currentTime,
                'updated_at'           => $currentTime,
            ]
        ];

        // Insere os dados na tabela 'usuarios'
        $this->db->table('usuarios')->insertBatch($data);
    }
}
