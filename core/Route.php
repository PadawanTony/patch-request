<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/19/16
 */

namespace Core;


class Route
{

    public static function get ($parameter, $default = null)
    {
        return array_key_exists($parameter, self::all())
            ? self::all()[ $parameter ]
            : $default;
    }

    /**
     * Get all of the get input for the request.
     *
     * @return array
     */
    public static function all () : array
    {
        return $_GET;
    }
}