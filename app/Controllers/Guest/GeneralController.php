<?php
namespace App\Controllers\Guest;


use App\Socialike\Article;
use Core\flash\Flash;
use Core\Request;
use Core\Response;
use Michelf\Markdown;

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

    //Test
    public function test ()
    {
        $article = Article::where(['id'=>11])->first();

        $body = Markdown::defaultTransform($article->body());

        return $this->view(
            'test',
            [
                'article'=>$article,
                'body'=>$body
            ]
        );
    }

    public function postTest ()
    {
        $article = Article::create(Request::all());

        Flash::success('Article created.');

        return Response::redirect("/test");
    }
}