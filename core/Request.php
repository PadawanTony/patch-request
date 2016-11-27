<?php declare(strict_types = 1);
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  10/23/16
 */

namespace Core;


/**
 * Class Request
 * @package Core
 */
class Request
{
    public static function methodIsGet ()
    {
        return strtolower(self::method()) == 'get';
    }

    public static function method () : string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Get post parameter
     *
     * @param      $parameter
     * @param null $default
     *
     * @return mixed|null
     */
    public static function get ($parameter, $default = null)
    {
        return array_key_exists($parameter, self::all())
            ? self::all()[ $parameter ]
            : $default;
    }

    /**
     * Get all of the input for the request.
     *
     * @return array
     */
    public static function all () : array
    {
        return $_POST;
    }

    public static function absoluteUri ()
    {
        return self::httpHostWithProtocol() . '/' . self::uri();
    }

    /**
     * @param $http
     *
     * @return string
     */
    private static function httpHostWithProtocol ():string
    {

        return self::httpProtocol() . $_SERVER['HTTP_HOST'];
    }

    /**
     * @return string
     */
    private static function httpProtocol ():string
    {
        if ( ! isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off')
        {
            return 'http://';
        }

        return 'https://';
    }

    public static function uri () : string
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
    }

    public static function only ($keys)
    {
        if ( ! is_array($keys))
        {
            $keys = [$keys];
        }

        return array_only($keys, self::all());
    }

    /**
     * We don't trust user/refer, so we'll use sessiosn, and fall back to referer if session is not yet set.
     * @return null
     */
    public static function previous ()
    {
        return Session::get(PREVIOUS_URL) ?? null;
    }
}