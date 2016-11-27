<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace Core;

class Session
{
    public static function all ()
    {
        return $_SESSION;
    }

    public static function put ($name, $value = null)
    {
        if (is_array($name))
        {
            foreach ($name as $key => $parameter)
            {
                $_SESSION[ $key ] = $parameter;
            }

            return;
        }

        $_SESSION[ $name ] = $value;
    }

    public static function has ($name)
    {
        return isset($_SESSION[ $name ]);
    }

    public static function extract ($name)
    {
        $value = self::get($name);

        self::remove($name);

        return $value;
    }

    /**
     * @param      $name
     *
     * @param null $default
     *
     * @return null
     */
    public static function get ($name, $default = null)
    {
        return $_SESSION[ $name ] ?? $default;
    }

    private static function remove ($name)
    {
        unset($_SESSION[ $name ]);
    }
}