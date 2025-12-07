<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuariosModel;
class APITokenFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
               $token = $request->getHeaderLine('Authorization');

        if (empty($token) || !str_contains($token, 'Bearer ')) {
            return service('response')->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Token de autorização ausente ou inválido.']);
        }

        $token = explode('Bearer ', $token)[1];
        $model = model(UsuariosModel::class);
        
        $user = $model->where('api_token', $token)->first();

        if (!$user) {
            return service('response')->setStatusCode(401)->setJSON(['status' => 'error', 'message' => 'Token inválido ou expirado.']);
        }

        // Passa os dados do usuário para o controlador, se necessário (opcional)
        $request->user = $user;
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
