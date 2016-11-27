<?php
namespace App\Controllers\Guest;

use App\Controllers\Controller;

class MarketingController extends Controller
{
    public function show ()
    {
        return $this->view('guest.landing_page');
    }
}