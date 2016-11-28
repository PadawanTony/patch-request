<?php
/**
 * User: antony
 * Date: 11/28/16
 * Time: 1:49 AM
 */

namespace App\Controllers\Guest;


use App\Controllers\Controller;
use Twig_Loader_Filesystem;

class GuestController extends Controller
{
    public function __construct ()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../../Views/guest');

        parent::__construct($loader);
    }
}