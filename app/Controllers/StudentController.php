<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class StudentController extends Controller
{
    public function score()
    {
        return view('student/score');
    }

    public function profile() 
    {
        return view('student/profile');
    }
}
