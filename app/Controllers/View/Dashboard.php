<?php

namespace App\Controllers\View;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data       = [
            'title' => 'Dashboard'
        ];
        return view('Dashboard',$data);
    }
}
