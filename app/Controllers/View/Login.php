<?php

namespace App\Controllers\View;

use App\Controllers\BaseController;

class Login extends BaseController
{
    public function index()
    {
        $data       = [
            'title' => 'User Login'
        ];
        return view('login/index', $data);
    }
}
