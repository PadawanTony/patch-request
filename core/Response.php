<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace Core;

use Core\flash\Flash;

class Response
{
    const HTTP_OK = 200;
    const HTTP_REDIRECT_TEMPORARY = 302;

    protected static $instance;

    public static function back ($status = Response::HTTP_REDIRECT_TEMPORARY, $headers = [])
    {
        $back = Request::previous();

        return self::redirect($back, $status, $headers);
    }

    public static function redirect ($path, $code = Response::HTTP_REDIRECT_TEMPORARY, $headers = [])
    {
        header("Location: {$path}", true, $code);

        // todo: add additional headers implementation when needed

        exit();
    }

    public static function instance ()
    {
        return self::$instance == null ? new static : self::$instance;
    }
}