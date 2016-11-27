<?php
/**
 * User: antony
 * Date: 11/19/16
 * Time: 8:17 PM
 */

namespace App\Http\Requests\Auth\Apps;

use App\Http\Requests\ValidateHttpRequest;

class UpdateAppRequest extends ValidateHttpRequest
{
    public function rules () : array
    {
        return [
            'name'  =>  'required|string',
        ];
    }
}