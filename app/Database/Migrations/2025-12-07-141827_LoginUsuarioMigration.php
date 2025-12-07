<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;


class LoginUsuarioMigration extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nome' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true, // Nome pode ser nulo, se necessário
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false, // Email pode ser nulo, se necessário
            ],
            'documento' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true, // Campo único
                'null'       => false, // Documento pode ser nulo, se necessário
            ],
            'login' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true, // Campo único
                'null'       => false, // Login pode ser nulo, se necessário
            ],
            'senha' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true, // Senha pode ser nulo, se necessário
            ],
            'telefone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true, // Telefone pode ser nulo, se necessário
            ],
            'situacao' => [
                'type'       => 'ENUM',
                'constraint' => ['logado', 'deslogado'], // Campo ENUM
                'default'    => 'deslogado',
            ],
            'termo_acesso' => [
                'type'       => 'ENUM',
                'constraint' => ['N', 'Y'], // Campo ENUM
                'default'    => 'N',
            ],
            'datetime_recuperacao' => [
                'type' => 'DATETIME',
                'null' => true, // Campo NOT NULL, mas note que o valor padrão será 0000-00-00 00:00:00 ou similar dependendo do DB
            ],
            'tempo_recuperacao' => [
                'type' => 'TIME', // Assumindo INT para o tempo (ex: segundos)
                'null' => true, // Campo NOT NULL
            ],
            'token_recuperacao' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true, // Campo NOT NULL
            ],
            'cep' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'uf' => [
                'type'       => 'CHAR',
                'constraint' => '2',
                'null'       => true,
            ],
            'cidade' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'bairro' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
                'null'       => true,
            ],
            'endereco' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'foto' => [
                'type' => 'TEXT', // Campo TEXT
                'null' => true, // Campo NOT NULL
            ],
            'nivel_acesso' => [
                'type'       => 'ENUM',
                'constraint' => ['admin', 'user'], // Campo ENUM
                'default'    => 'user',
            ],
            'last_login_ip' => [
                'type'       => 'VARCHAR',
                'constraint' => '45',
                'null'       => true,
            ],
            'api_token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Define a chave primária
        $this->forge->addUniqueKey('email'); // Adiciona chave única para o email
        $this->forge->createTable('usuarios'); // Cria a tabela com o nome 'usuarios'
    }

    public function down()
    {
        $this->forge->dropTable('usuarios'); // Remove a tabela em caso de rollback
    }
}
