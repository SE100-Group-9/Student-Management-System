<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CashierController extends Controller
{
    public function list()
    {
        return view('cashier/payment/list');
    }

    public function profile() 
    {
        return view('cashier/profile');
    }

    public function add()
    {
        return view('cashier/payment/add');
    }

    public function staticStudent()
    {
        return view('cashier/statics/student');
    }

    public function changepw()
    {
        return view('cashier/changepw');
    }
}
