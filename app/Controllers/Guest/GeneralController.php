<?php
namespace App\Controllers\Guest;

use App\Controllers\Controller;

class GeneralController extends Controller
{
    public function index ()
    {
        return $this->view('guest.index');
    }
}