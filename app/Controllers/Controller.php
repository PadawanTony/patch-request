<?php
namespace App\Controllers;

use App\Http\Form;
use App\Socialike\Element\HtmlGenerator;
use Core\App;
use Core\flash\Flash;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

abstract class Controller
{
    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * AdminController constructor.
     */
    public function __construct ()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../Views/');

        $this->twig = new Twig_Environment($loader, [
            'debug'       => App::get('config.app')['debug'],
            'cache'       => App::get('config.app')['storage.cache'],
            'auto_reload' => true,
        ]);

        $this->twig->addGlobal('form', new Form());

        $this->twig->addGlobal('flash', Flash::instance());

        $this->twig->addGlobal('element', new HtmlGenerator());

        if (App::get('config.app')['debug'])
        {
            $this->twig->addExtension(new Twig_Extension_Debug());
        }
    }

    public function view ($twig, array $data = [])
    {
        $twig = str_replace('.', '/', $twig);

        return $this->twig->render($twig . '.twig', $data);
    }
}