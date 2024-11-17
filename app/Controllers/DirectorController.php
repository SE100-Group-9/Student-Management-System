<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DirectorController extends Controller
{
    public function dashboard()
    {
        return view('director/dashboard');
    }

    public function news()
    {
        return view('director/news');
    }

    public function staticsConduct()
    {
        return view('director/statics/conduct');
    }

    public function staticsGrade()
    {
        return view('director/statics/grade');
    }

    public function staticsStudent()
    {
        return view('director/statics/student');
    }
}
