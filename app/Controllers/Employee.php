<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;
use App\Models\ApiKeyModel;
// use Config\Database;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Filter\ApiKeyFilter;


// use Config\ApiConfig;


class Employee extends ResourceController
{
    use ResponseTrait;

    // public function postman() {

    //     $request = $this->request->getPost();

    //     $apiKey = $this->request->getHeaderLine('X-API-Key');

    //     $test = $this->is_API($apiKey);

        

    //     $model = new ApiKeyModel();

    //     $databaseApiKey = $model->getApiKey();

    //     if($apiKey == $databaseApiKey) {

    //         return $this->respond('API key is valid', ResponseInterface::HTTP_OK);
    //     }

    //     else{
    //         return $this->respond('Invalid API key', ResponseInterface::HTTP_UNAUTHORIZED);
        
    //     }

    // }

    public function inde()
    {
        // // $apikey = 'abc123';
        // $model = new ApikeyModel();
        // $result = $model->where('apikeys', $apikey)->first();
        // echo '<pre>';
        // print_r($result);
        // die;

        return view('form');
    }

    // all users
    public function index(){        
        // $apiKey = $this->request->getHeaderLine('X-API-Key');
        // if (!in_array($apiKey, ApiConfig::$apiKey)) {
        //     return $this->failNotFound('Invalid API key');
        // }
            $apiKey = $this->request->getHeaderLine('X-API-Key');

        // $test = $this->is_API($apiKey);
        // if($test){
            $model = new EmployeeModel();
            $data['employees'] = $model->orderBy('id', 'ASC')->findAll();
            return $this->respond($data);
        // }
    }
 
    // creates a user
    public function create() {
    $model = new EmployeeModel();
        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
        ];
        $model->insert($data);
        $response = [
          'status'   => 201,
          'error'    => null,
          'messages' => [
            'success' => 'Employee created successfully'
          ]
      ];
      return $this->respondCreated($response);
    }

    // single user
    public function show($id = null){
        $model = new EmployeeModel();
        $data = $model->where('id', $id)->first();
        if($data){
            return $this->respond($data);
        }else{
            return $this->failNotFound('No employee found');
        }
    }

    // update a single user
    public function update($id = null){
        $model = new EmployeeModel();
        $id = $this->request->getVar('id');
        $data = [
            'name' => $this->request->getVar('name'),
            'email'  => $this->request->getVar('email'),
        ];
        $model->where('id', $id)->update($id, $data);
        $response = [
          'status'   => 200,
          'error'    => null,
          'messages' => [
              'success' => 'Employee updated successfully'
          ]
      ];
      return $this->respond($response);
    }

    // deletes a single user
    public function delete($id = null){
        $model = new EmployeeModel();
        $data = $model->where('id', $id)->delete($id);
        if($data){
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Employee successfully deleted'
                ]
            ];
            return $this->respondDeleted($response);
        }else{
            return $this->failNotFound('No employee found');
        }
    }
    // private function is_API($apiKey) {
    //     $apimodel = new ApikeyModel();

    //     $result = $apimodel->where('apikeys', $apiKey)->first();
    //     if($result){
    //     return true;
    //     }
    //     else {
    //         $response = service('response');
    //         $response->setStatusCode(401);
    //         $data = $response->setJSON([
    //             'status' => 401,
    //             'error' => 'Unauthorized',
    //             'message' => 'Invalid API key',
    //             'apiKey' => $apiKey,
    //         ]);
    //         $response->error($data);
    //         return $response;
    //         // $response->success(false);
    //         // return $this->$response(setJSON);
            
    //     }




    // }
}
