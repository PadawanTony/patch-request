<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Http\Requests;

/**
 * Interface ValidateRequest
 * Validates requests. Redirects back if errors where found.
 * @package App\Http\Requests
 */
interface FormRequest
{
    public function rules () : array;

    public function validate ();
}