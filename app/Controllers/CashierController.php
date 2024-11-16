<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CashierController extends Controller
{
    public function list()
    {
        return view('cashier/payment/list');
    }

    public function extense()
    {
        return view('cashier/extense');
    }

    public function profile() 
    {
        return view('cashier/profile');
    }

    public function viewinfo()
    {
        return view('cashier/payment/viewinfo');
    }
}
