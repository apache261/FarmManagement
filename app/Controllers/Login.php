<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
// php spark make:controller Login --restful
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;


class Login extends ResourceController
{

    use ResponseTrait;
    public function index()
    {

        $email          = $this->request->getVar('email');
        $pass           = $this->request->getVar('password');
        $token          = "";
        $model          = new UserModel();

        helper(['form']);
        $rules          = [
                        'email' => 'required|valid_email',
                        'password' => 'required|min_length[6]'
                        ];

        if(!$this->validate($rules)){
            return $this->fail($this->validator->getErrors());
        }
        
        $user           = $model->where("email",$email)->first();

        if(!$user){
            return $this->failNotFound('Email does not Exist');
        }

        $verify         = password_verify($pass,$user['password']);

        if(!$verify){
            return $this->fail('Invalid Password');
        }
        $token          = $this->generateToken($user);
        $data['token']  = $token;
        $data['status'] = 200;
        $data['error']  = null;
        $data['message'] = "Success";
        $data['redirect'] = base_url();
        return $this->respond($data);
    }

    private function generateToken($userinfo){
        $key        = getenv('JWT_SECRET');
        $iss        = 'king';
        $aud        = base_url();
        $iat        = time();
        $nbf        = $iat + 1;
        $exp        = $iat + 7100;
        $payload    = array(
                "iss"  => $iss,
                "aud"  => $aud,
                "iat" => $iat,
                "nbf" => $nbf,
                "exp"  => $exp,
                "user" => [
                    "id" => $userinfo['id'],
                    "email" => $userinfo['email']
                ]
            );
        $token      = JWT::encode($payload,$key);
        return $token;
    }

    
}
