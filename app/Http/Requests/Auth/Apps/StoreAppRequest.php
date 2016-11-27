<?php
namespace App\Http\Requests\Auth\Apps;

use App\Http\Requests\ValidateHttpRequest;

/**
 * User: antony
 * Date: 11/18/16
 * Time: 2:42 PM
 */
class StoreAppRequest extends ValidateHttpRequest
{

    public function rules () : array
    {
        return [
            'name'  =>  'required|string',
        ];
    }
}