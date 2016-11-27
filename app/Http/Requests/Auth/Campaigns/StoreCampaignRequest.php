<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Http\Requests\Auth\Campaigns;

use App\Http\Requests\ValidateHttpRequest;

class StoreCampaignRequest extends ValidateHttpRequest
{
    public function rules () : array
    {
        return [
            'ngo_id'                 => 'required|exists:ngos,id',
            'title'                  => 'required|string',
            'budget_cents'           => 'required|numeric',
            'payment_cents'          => 'required|numeric',
            'start_date'             => 'required|date',
            'end_date'               => 'required|date',
        ];
    }
}