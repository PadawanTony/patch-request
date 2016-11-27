<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/12/16
 */

namespace Core;

use App\Socialike\Model\Model;
use Core\database\DB;
use DateTime;

class Validator
{
    /**
     * @var Validator instance
     */
    protected static $instance;
    protected $fails = false;
    protected $messages = [];
    protected $allRules = [
        'required' => 'required',
        'numeric'  => 'numeric',
        'date'     => 'date',
        'string'   => 'string',
        'exists'   => 'exists',
        'unique'   => 'unique',
        'min'   => 'min',
    ];

    public static function instance ()
    {
        return self::$instance == null ? new self : self::$instance;
    }

    /**
     * @param array $parameters
     * @param array $rules
     */
    public function make (array $parameters, array $rules)
    {
        $this->fails = false;

        foreach ($rules as $key => $masterRule)
        {
            $internalRules = explode('|', $masterRule);

            $parameter = array_key_exists($key, $parameters) ? $parameters[ $key ] : null;

            foreach ($internalRules as $rule)
            {
                $functionName = explode(':', $rule)[0];

                $break = call_user_func(
                    [$this, $this->allRules[ $functionName ]], $parameter, $key, $rule
                );

                if ($break)
                {
                    break;
                }
            }
        }
    }

    /**
     * @return boolean
     */
    public function fails (): bool
    {
        return $this->fails;
    }

    /**
     * @return array
     */
    public function messages (): array
    {
        return $this->messages;
    }

    /**
     * @param $parameter
     * @param $key
     *
     * @return bool
     */
    private function required ($parameter, $key, $rule)
    {
        if (empty($parameter))
        {
            $message = "$key is required.";

            $this->handleFailedValidation($parameter, $key, $message);

            return true;
        }

        return false;
    }

    /**
     * @param $parameter
     * @param $key
     * @param $message
     */
    private function handleFailedValidation ($parameter, $key, $message)
    {
        $this->messages[ $key ] = $this->parseMessage($message);

        $this->fails = true;
    }

    /**
     * @param $message
     *
     * @return string
     *
     */
    private function parseMessage ($message):string
    {
        $message = ucfirst($message);

        return str_replace('_', ' ', $message);
    }

    /**
     * @param $parameter
     * @param $key
     *
     * @return bool
     */
    private function numeric ($parameter, $key, $rule)
    {
        if ( ! is_numeric($parameter))
        {
            $message = "$key must be numeric.";

            $this->handleFailedValidation($key, $parameter, $message);

            return true;
        }

        return false;
    }

    /**
     * @param $parameter
     * @param $key
     *
     * @return bool
     */
    private function min ($parameter, $key, $rule)
    {
        $min = explode(':', $rule)[1];

        if ($parameter < $min)
        {
            $message = "$key must be at least $min.";

            $this->handleFailedValidation($key, $parameter, $message);

            return true;
        }

        return false;
    }

    /**
     * @param $parameter
     * @param $key
     *
     * @return bool
     */
    private function date ($parameter, $key, $rule)
    {
        $format = 'Y-m-d H:i:s';

        $dateTime = DateTime::createFromFormat($format, $parameter);

        if ( ! ($dateTime && $dateTime->format($format) === $parameter))
        {
            $message = "$key must be a date.";

            $this->handleFailedValidation($parameter, $key, $message);

            return true;
        }

        return false;
    }

    /**
     * @param $parameter
     * @param $key
     *
     * @return bool
     */
    private function string ($parameter, $key, $rule)
    {
        if ( ! is_string($parameter))
        {
            $this->messages[] = $this->parseMessage("$key must be string.");

            $this->fails = true;

            return true;
        }

        return false;
    }

    /**
     * @param $parameter
     * @param $key
     *
     * @param $rule
     *
     * @return bool
     */
    private function exists ($parameter, $key, $rule)
    {
        $data = explode(':', $rule)[1];
        $data = explode(',', $data);
        $table = $data[0];
        $tableColumn = $data[1];
        $id = $parameter;

        $model = Model::getModelByTable($table);

        $found = DB::table(new $model)->first(['*'], [$tableColumn => $id]);

        if ( ! $found)
        {
            $this->messages[ $key ] = $this->parseMessage("$key is invalid.");

            $this->fails = true;

            return true;
        }

        return false;
    }

    /**
     * @param $parameter
     * @param $key
     *
     * @param $rule
     *
     * @return bool
     */
    private function unique ($parameter, $key, $rule)
    {
        $data = explode(':', $rule)[1];
        $data = explode(',', $data);
        $table = $data[0];
        $tableColumn = $data[1];
        $whereNotKeyValue = array_key_exists(2, $data) ? $data[2] : false;
        $column = $parameter;

        $model = Model::getModelByTable($table);

        if ($whereNotKeyValue)
        {
            $model->where(['key' => 'id', 'comparison' => '!=', 'value' => $whereNotKeyValue]);
        }

        $results = $model->where([$tableColumn => $column])->first(['*']);

        if ($results)
        {
            $this->messages[ $key ] = $this->parseMessage("$key already exists.");

            $this->fails = true;

            return true;
        }

        return false;
    }
}