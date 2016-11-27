<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/bootstrap/app.php';

use Core\Request;
use Core\Router;
use Core\Session;


Router::load([
    'guest',
    'auth',
]);

echo Router::direct(Request::uri(), Request::method());

// By this point all backend code is executed.
// We use the below session instead of the server referer as we do not trust the users.
if (Request::methodIsGet())
{
    Session::put(PREVIOUS_URL, Request::absoluteUri());
}
