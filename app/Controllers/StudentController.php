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

    public function final_result()
    {
        return view('student/final_result');
    }

    public function fee_payment()
    {
        return view('student/fee_payment');
    }

    public function conduct()
    {
        return view('student/conduct');
    }

    public function fee_info()
    {
        return view ('student/fee_info');
    }

    public function changepw()
    {
        return view('student/changepw');
    }
}
