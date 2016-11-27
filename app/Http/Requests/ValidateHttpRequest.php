<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Http\Requests;

use Core\flash\Flash;
use Core\Request;
use Core\Session;
use Core\Validator;

abstract class ValidateHttpRequest implements FormRequest
{
    protected $messages;
    /**
     * @var Validator
     */
    private $validator;

    /**
     * ValidateFormRequest constructor.
     *
     * @param Validator $validator
     */
    public function __construct (Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validate ()
    {
        $keys = array_keys($this->rules());

        $this->validator->make(Request::only($keys), $this->rules());

        Session::put(Request::only($keys)); // Fill whole form

        if ( ! ($failed = $this->validator->fails()))
        {
            return ! $failed;
        }

        $messages = $this->validator->messages();

        Flash::error('Form validation failed.');

        array_walk($messages, function ($message, $index)
        {
            Flash::formError($index, $message);
        });

        return ! $failed;
    }

    abstract public function rules () : array;
}