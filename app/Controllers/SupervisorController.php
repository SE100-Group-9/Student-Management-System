<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class SupervisorController extends Controller
{
    public function fault()
    {
        return view('supervisor/fault');
    }

    public function profile()
    {
        return view('supervisor/profile');
    }

    public function category()
    {
        return view('supervisor/category');
    }

    public function addfault()
    {
        return view('supervisor/addfault');
    }
}
