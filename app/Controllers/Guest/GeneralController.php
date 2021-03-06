<?php
namespace App\Controllers\Guest;


class GeneralController extends GuestController
{
    public function home ()
    {
        return $this->view('home');
    }

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

    //Tentative Articles
    public function cleardb ()
    {
        return $this->view('articles/cleardb');
    }

    public function dom_crawler ()
    {
        return $this->view('articles/dom_crawler');
    }

    public function update_path ()
    {
        return $this->view('articles/update_path');
    }
}