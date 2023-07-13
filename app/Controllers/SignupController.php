<?php 
namespace App\Controllers;  
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
  
class SignupController extends Controller
{
    public function index()
    {
        helper(['form']);
        $data = [];
        echo view('signup', $data);
    }

    public function store()
    {
        helper(['form']);
        $data = [
            'name' => $this->request->getVar('name'),
            'email' => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'),
            'confirmpassword' => $this->request->getVar('confirmpassword')
        ];

        if ($data['password'] !== $data['confirmpassword']) {
            $response = [
                'status' => 400,
                'message' => 'Password and Confirm Password do not match.'
            ];

            return $this->response->setJSON($response)->setContentType('application/json')->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }

        $rules = [
            'name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[4]|max_length[50]',
            'confirmpassword' => 'required'
        ];

        if ($this->validate($rules)) {
            $userModel = new UserModel();
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            unset($data['confirmpassword']);

            $userModel->save($data);

            $response = [
                'status' => 200,
                'message' => 'User created successfully.'
            ];

            return $this->response->setJSON($response)->setContentType('application/json')->setStatusCode(ResponseInterface::HTTP_OK);
        } else {
            $data['validation'] = $this->validator->getErrors();
            return $this->response->setJSON($data)->setContentType('application/json')->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
        }
    }
  
    // public function store()
    // {
    //     helper(['form']);
    //     $rules = [
    //         'name'          => 'required|min_length[2]|max_length[50]',
    //         'email'         => 'required|min_length[4]|max_length[100]|valid_email|is_unique[users.email]',
    //         'password'      => 'required|min_length[4]|max_length[50]|matches[confirmpassword]',
    //         'confirmpassword'  => 'required'
    //     ];

    //     // $password = $this->request->getPost('password');
    //     // $confirmpassword = $this->request->getPost('confirmpassword');

    //     // if ($password !== $confirmpassword) {
    //     //     echo "Password: " . $password . "<br>";
    //     //     echo "Confirm Password: " . $confirmpassword . "<br>";
    //     //     die("Passwords do not match.");
    //     // }
          
    //     if($this->validate($rules)){
    //         $userModel = new UserModel();
    //         $data = [
    //             'name'     => $this->request->getPost('name'),
    //             'email'    => $this->request->getPost('email'),
    //             'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT)
    //         ];
    //         $userModel->save($data);

    //         $response = [
    //         'status' => 200,
    //         'message' => 'User created successfully.'
    //         ];
            
    //         return $this->response->setJSON($response)->setContentType('application/json')->setStatusCode(ResponseInterface::HTTP_OK);
    //         // return redirect()->to('/signin');
    //     }
    //     else{
    //         $data['validation'] = $this->validator->getErrors();;
    //         return $this->response->setJSON($data)->setContentType('application/json')->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST);
    //         // return view('signup', $data);

    //     }
          
    // }
  
}