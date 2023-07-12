<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use App\Models\ApiKeyModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Filter\ApiKeyFilter;

class SigninController extends ResourceController
{
    public function index()
    {
        helper(['form']);
        echo view('signin');
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();
        $name = $this->request->getVar('name');
        $password = $this->request->getVar('password');

        $data = $userModel->where('name', $name)->first();

        if ($data) {
            $pass = $data['password'];
            $isPasswordCorrect = password_verify($password, $pass);

            if ($isPasswordCorrect) {
                $apiKey = $this->generateApiKey();

                $apiKeyModel = new ApiKeyModel();
                $apiKeyModel->insert([
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'apikeys' => $apiKey,
                ]);

                $response = [
                'status' => Response::HTTP_OK,
                'message' => 'Login successful',
                'user' => [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'apiKey' => $apiKey,
                    ]
                ];
                return $this->respond($response, Response::HTTP_OK);


                // $this->storeApiKey($data['id'], $apiKey); 

                // $ses_data = [
                //     'id' => $data['id'],
                //     'name' => $data['name'],
                //     'email' => $data['email'],
                //     'isLoggedIn' => true,
                //     'apiKey' => $apiKey,
                // ];

                // $session->set($ses_data);
                // return redirect()->to('/profile');
            } 
            else {
                $response = [
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'message' => 'Password is incorrect.',
                ];

                return $this->respond($response, Response::HTTP_UNAUTHORIZED);
            }
            // else {
            //     $session->setFlashdata('msg', 'Password is incorrect.');
            //     return redirect()->to('/signin')->withInput();
            // }
        } 
        else {
            $response = [
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Name does not exist.',
            ];

            return $this->respond($response, Response::HTTP_UNAUTHORIZED);
        }
        // else {
        //     $session->setFlashdata('msg', 'Name does not exist.');
        //     return redirect()->to('/signin')->withInput();
        // }
    }

    private function generateApiKey()
    {
        $length = 16;
        $bytes = random_bytes($length);
        return bin2hex($bytes);
    }

    // private function storeApiKey($userId, $apiKey)
    // {
    //     $apiKeyModel = new ApiKeyModel();
    //     $apiKeyModel->insert([
    //         'user_id' => $userId,
    //         'api_key' => $apiKey,
    //     ]);
    // }
}
