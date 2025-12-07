<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Entities\UsuarioEntity;

class UsuariosModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = UsuarioEntity::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome', 'email', 'documento', 'login', 'senha', 'telefone', 'situacao', 
        'termo_acesso', 'datetime_recuperacao', 'tempo_recuperacao', 
        'token_recuperacao', 'cep', 'uf', 'cidade', 'bairro', 'endereco', 
        'foto', 'nivel_acesso', 'last_login_ip', 'api_token'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = ['hashPassword'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Função callback para fazer o hash da senha automaticamente.
     * 
     * @param array $data Dados a serem inseridos/atualizados
     * @return array Dados modificados
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['senha'])) {
            // Aplica o hash PASSWORD_DEFAULT
            $data['data']['senha'] = password_hash($data['data']['senha'], PASSWORD_DEFAULT);
        }

        return $data;
    }
}
