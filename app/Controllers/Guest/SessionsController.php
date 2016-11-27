<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  10/25/16
 */

namespace App\Controllers\Guest;

use App\Controllers\Controller;
use Core\Request;

class SessionsController extends Controller
{
    public function create ()
    {
        return $this->view('guest.login');
    }

    public function store ()
    {
        ddd(Request::all());
    }

    public function delete ()
    {
        ddd('Delete users authentication sessions (logout)');
    }
}