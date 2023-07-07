<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = $request->getHeaderLine('X-API-Key');
        $validApiKeys = ['abc123', 'ceba20'];
        echo 'API Key: ' . $apiKey; 

        if (!in_array($apiKey, $validApiKeys)) {
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
