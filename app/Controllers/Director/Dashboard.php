<?php

namespace App\Controllers\Director;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        // Tải view 'director/dashboard'
        return view('director/dashboard');
    }
}
