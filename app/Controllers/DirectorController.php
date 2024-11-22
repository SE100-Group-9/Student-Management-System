<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class DirectorController extends Controller
{

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

    public function titleList()
    {
        return view('director/title/list');
    }

    public function titleAdd()
    {
        return view('director/title/add');
    }

    public function titleUpdate()
    {
        return view('director/title/update');
    }

    public function classList()
    {
        return view('director/class/list');
    }

    public function classAdd()
    {
        return view('director/class/add');
    }
    public function classUpdate()
    {
        return view('director/class/update');
    }

    public function classArrangeStudent()
    {
        return view('director/class/arrange/student');
    }

    public function classArrangeTeacher()
    {
        return view('director/class/arrange/teacher');
    }
}
