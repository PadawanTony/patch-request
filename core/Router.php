<?php namespace Core;

use App\Exceptions\HttpNotFoundException;
use App\Http\Requests\FormRequest;
use App\Socialike\App\App as MobileApp;
use App\Socialike\Campaign\Campaign;
use App\Socialike\Ngo\Ngo;
use App\Socialike\Question\Question;
use Exception;
use InvalidArgumentException;
use ReflectionClass;

/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @author Antony Kalogeropoulos <anthonykalogeropoulos@gmail.com>
 * @since  10/23/16
 */
class Router
{
    const POST = 'POST';
    const GET = 'GET';
    /**
     * @var array
     */
    protected static $routes = [
        self::GET  => [],
        self::POST => [],
    ];
    private static $modelBindings = [];
    private static $regexModels = [
        'question_id' => Question::class,
        'campaign_id' => Campaign::class,
        'ngo_id'      => Ngo::class,
        'app_id'      => MobileApp::class,
    ];

    /**
     * @param array $files
     */
    public static function load (array $files)
    {
        array_walk($files, function ($file)
        {
            $path = __DIR__ . "/../routes/{$file}.php";

            if ( ! file_exists($path))
            {
                throw new InvalidArgumentException("No such file at {$path}");
            }

            require $path;
        });
    }

    /**
     * @param $uri
     * @param $method
     *
     * @return mixed
     * @throws HttpNotFoundException
     */
    public static function direct ($uri, $method)
    {
        $routes = array_merge(static::$routes[ self::GET ], static::$routes[ self::POST ]);

        foreach ($routes as $pattern => $route)
        {
            $uri = self::bindModels($pattern, $uri);
        }

        if ( ! array_key_exists($uri, static::$routes[ $method ]))
        {
            throw new HttpNotFoundException;
        }

        return static::callAction(
            ...explode('@', static::$routes[ $method ][ $uri ])
        );
    }

    /**
     * Attempts to find model pattern, e.g. {campaign_id}.
     * If it does so, then it extract the relevant id number and instantiates the relevant model, retrieving it's
     * data from the database.
     *
     * @param $routePattern
     * @param $uri
     *
     * @return mixed
     */
    private static function bindModels ($routePattern, $uri)
    {
        foreach (self::$regexModels as $regex => $model)
        {
            if ( ! preg_match("/\{$regex\}/", $routePattern))
            {
                continue;
            }

            $regexReadyPattern = preg_replace("/\//", '\/', $routePattern);
            $regexReadyPattern = preg_replace("/\{$regex\}/", '\d+', $regexReadyPattern);

            if ( ! preg_match("/$regexReadyPattern/", $uri, $matches))
            {
                continue;
            }

            $uriFound = $matches[0];

            preg_match('/\d+/', $uriFound, $ids);

            $id = $ids[0];

            $uriPattern = preg_replace('/' . $regexReadyPattern . '/', $routePattern, $uri, 1);

            $model = new $model();

            $model = $model->where(compact('id'))->first();

            self::$modelBindings[] = $model;

            $uri = $uriPattern;
        }

        return $uri;
    }

    /**
     * @param $controller
     * @param $action
     *
     * @return mixed
     * @throws Exception
     */
    private static function callAction ($controller, $action)
    {
        $controller = str_replace('/', '\\', $controller);
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if ( ! method_exists($controller, $action))
        {
            throw new Exception(get_class($controller) . " does not respond to the {$action} action.");
        }

        $formRequests = static::getFormRequests($controller, $action);

        static::validateFormRequests($formRequests);

        $bindings = array_merge(self::$modelBindings, $formRequests);

        return $controller->$action(...$bindings);
    }

    /**
     * @param $controller
     * @param $action
     *
     * @return array
     */
    private static function getFormRequests ($controller, $action) : array
    {
        $formRequests = [];
        $reflectClass = new ReflectionClass(get_class($controller));

        foreach ($reflectClass->getMethod($action)->getParameters() as $parameters)
        {
            $class = $parameters->getClass();

            if (in_array(FormRequest::class, $class->getInterfaceNames()))
            {
                $validator = new Validator();

                $formRequests[] = new $class->name($validator);
            }
        }

        return $formRequests;
    }

    /**
     * Validates requests. Redirects back with error messages, if errors where found.
     *
     * @param array $requests
     *
     * @return bool|void
     */
    private static function validateFormRequests (array $requests)
    {
        foreach ($requests as $formRequest)
        {
            if ( ! $formRequest->validate())
            {
                return Response::back();
            }
        }

        return true;
    }

    /**
     * @param $uri
     * @param $controller
     */
    public static function get ($uri, $controller)
    {
        static::$routes[ self::GET ][ $uri ] = $controller;
    }

    /**
     * @param $uri
     * @param $controller
     */
    public static function post ($uri, $controller)
    {
        static::$routes[ self::POST ][ $uri ] = $controller;
    }

}