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

    public function studentAdd()
    {
        return view('director/student/add');
    }

    public function studentUpdate()
    {
        return view('director/student/update');
    }

    public function studentList()
    {
        return view('director/student/list');
    }

    public function studentPayment()
    {
        return view('director/student/payment');
    }

    public function studentPerserved()
    {
        return view('director/student/perserved');
    }

    public function studentRecord()
    {
        return view('director/student/record');
    }
}
