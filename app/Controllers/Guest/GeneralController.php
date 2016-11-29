<?php
namespace App\Controllers\Guest;


class GeneralController extends GuestController
{
    public function blog ()
    {
        return $this->view('blog');
    }

    public function article ()
    {
        return $this->view('article');
    }

    public function about ()
    {
        return $this->view('about');
    }

    public function contact ()
    {
        return $this->view('contact');
    }
}