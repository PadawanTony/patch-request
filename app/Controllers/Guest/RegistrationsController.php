<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/20/16
 */

namespace App\Controllers\Guest;

use App\Controllers\Controller;

class RegistrationsController extends Controller
{
    public function create ()
    {
        return $this->view('register');
    }

    public function store ()
    {
        ddd(Request::all());
    }

}