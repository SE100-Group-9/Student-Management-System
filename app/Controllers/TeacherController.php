<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TeacherController extends Controller
{
    public function statics()
    {
        return view('teacher/statics/grade');
    }

    public function studentList()
    {
        return view('teacher/student/list');
    }

    public function classRate()
    {
        return view('teacher/class/rate');
    }

    public function classRating()
    {
        return view('teacher/class/rating');
    }

    public function recordDetail()
    {
        return view('teacher/class/record/detail');
    }

    public function recordList()
    {
        return view('teacher/class/record/list');
    }

    public function enterList()
    {
        return view('teacher/class/enter/list');
    }

    public function enterNext()
    {
        return view('teacher/class/enter/next');
    }

    public function enterStudent()
    {
        return view('teacher/class/enter/student');
    }

    public function profile()
    {
        return view('teacher/profile');
    }

    public function changepw()
    {
        return view('teacher/changepw');
    }
}
