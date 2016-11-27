<?php declare(strict_types = 1);
/**
 * Custom global functions. Avoid over creating.
 *
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  10/23/16
 */
use Core\App;

/**
 * @param      $name
 * @param null $default
 *
 * @return string|null
 */
function env ($name, $default = null)
{
    return false === getenv($name) ? $default : getenv($name);
}

/**
 * Checking current environment
 *
 * @param $string
 *
 * @return bool
 */
function environment ($string) : bool
{
    return env('APP_ENV') == $string;
}

/**
 * Useful to echo stuff without too much other code overhead (styling)
 *
 * @param $data
 */
function ve ($data)
{
    if (is_object($data))
    {
        $methods = get_class_methods($data);

        array_walk($methods, function ($method) use (&$data)
        {
            $data->methods[] = $method;
        });
    }

    var_dump($data);

    exit;
}

/**
 * @return \Faker\Generator
 */
function faker ()
{
    return App::get('faker');
}

/**
 * Get only the elements having the given keys.
 *
 * @param string|array $keys
 * @param array        $array
 *
 * @return mixed|null
 */
function array_only ($keys, array $array)
{
    if ( ! is_array($keys))
    {
        $keys = [$keys];
    }

    return array_filter($array, function ($index) use ($keys)
    {
        return in_array($index, $keys);
    }, ARRAY_FILTER_USE_KEY);
}
