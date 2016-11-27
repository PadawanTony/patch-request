<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/9/16
 */

namespace Core\flash;

class Flash
{
    const FORM_ERRORS = 'form.errors';
    const FLASH = 'flash';
    protected static $instance;

    public static function error ($string)
    {
        self::message($string, 'error');
    }

    private static function message ($string, $type)
    {
        $_SESSION[ self::FLASH ][] = ['type' => $type, 'message' => $string];
    }

    public static function success ($string)
    {
        self::message($string, 'success');
    }

    /**
     * @return array
     */
    public static function all ()
    {
        $messages = $_SESSION[ self::FLASH ] ?? [];

        unset($_SESSION[ self::FLASH ]);

        return $messages;
    }

    public static function instance ()
    {
        return self::$instance == null ? new static : self::$instance;
    }

    public static function formError ($key, $message, $type = 'error')
    {
        $_SESSION[ self::FORM_ERRORS ][ $key ] = ['type' => $type, 'message' => $message];
    }

    public static function hasFormError ($name) : bool
    {
        return ! empty($_SESSION[ self::FORM_ERRORS ]) && ! empty($_SESSION[ self::FORM_ERRORS ][ $name ]);
    }

    public static function getFormError ($name) : array
    {
        $error = $_SESSION[ self::FORM_ERRORS ][ $name ];

        unset($_SESSION[ self::FORM_ERRORS ][ $name ]);

        return $error;
    }
}