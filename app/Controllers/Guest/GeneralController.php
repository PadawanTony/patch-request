<?php
namespace App\Controllers\Guest;


class GeneralController extends GuestController
{
    public function index ()
    {
        return $this->view('index');
    }
}