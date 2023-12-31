<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ApikeyModel;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $model = new ApikeyModel();
        $apiKey = $request->getHeaderLine('X-API-Key');
        $result = $model->where('apikeys', $apiKey)->first();
        
        if (!$result) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setJSON([
                'status' => 401,
                'error' => 'Unauthorized',
                'message' => 'Invalid API key',
                'apiKey' => $apiKey,
            ]);
            return $response;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after the request
    }
}

