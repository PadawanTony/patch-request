<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Http\Requests\Auth\Ngos;

use App\Http\Requests\ValidateHttpRequest;
use Core\Request;

class UpdateNgoRequest extends ValidateHttpRequest
{
    public function rules () : array
    {
        return [
            'name' => 'required|string|unique:ngos,name,' . Request::get('id'),
        ];
    }
}