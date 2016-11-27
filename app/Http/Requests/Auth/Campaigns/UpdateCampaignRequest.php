<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Http\Requests\Auth\Campaigns;

use App\Http\Requests\ValidateHttpRequest;
use Core\Request;

class UpdateCampaignRequest extends ValidateHttpRequest
{
    public function rules () : array
    {
        return [
            'ngo_id'        => 'required|exists:ngos,id',
            'description'   => 'string',
            'title'         => 'required|string|unique:campaigns,title,' . Request::get('id'),
            'budget_cents'  => 'required|numeric',
            'payment_cents' => 'required|numeric',
            'start_date'    => 'required|date',
            'end_date'      => 'required|date',
        ];
    }
}