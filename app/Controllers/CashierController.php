<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CashierController extends Controller
{
    public function payment()
    {
        return view('cashier/payment');
    }

    public function extense()
    {
        return view('cashier/extense');
    }
}
