<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SupervisorController extends Controller
{
    public function fault()
    {
        return view('supervisor/fault');
    }
}
