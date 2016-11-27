<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/20/16
 */

namespace App\Controllers\Auth;

use App\Controllers\Controller;
use App\Socialike\Faker;
use App\Socialike\Response\Response;

class ResponsesController extends Controller
{
    public function index ()
    {
//        Faker::response();

        $responses = Response::all();

//        ddd($responses->get(0)->question->campaign);

        return $this->view('auth.responses.index', compact('responses'));
    }
}