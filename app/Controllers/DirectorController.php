<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DirectorController extends Controller
{
    public function dashboard()
    {
        return view('director/dashboard');
    }
}
