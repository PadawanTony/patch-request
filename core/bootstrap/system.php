<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/12/16
 */

use Core\App;
use Core\Request;
use Core\Session;

date_default_timezone_set(App::get('config.app')['timezone']);

session_start();
