<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/10/16
 */

namespace App\Socialike\Campaign\Creator;


use App\Socialike\Campaign\Campaign;
use App\Socialike\Campaign\CampaignException;
use Core\Validator;
use Exception;

class CreatesCampaign
{
    private static $rules = [
        'ngo_id'                 => 'required|exists:ngos,id',
        'surveyor_id'            => 'required|exists:users,id',
        'title'                  => 'required|string',
        'budget_cents'           => 'required|numeric',
        'remaining_budget_cents' => 'required|numeric',
        'payment_cents'          => 'required|numeric',
        'start_date'             => 'required|date',
        'end_date'               => 'required|date',
    ];

    /**
     * All data must be already valdated.
     *
     * @param array                   $data
     * @param CreatesCampaignListener $listener
     *
     * @return mixed
     */
    public function handle (array $data, CreatesCampaignListener $listener)
    {
        // todo: throw exception if invaild data
        $this->guardAgainstInvalidParameters($data);

        $data = array_only(Campaign::columns(), $data);

        try
        {
            $campaign = Campaign::create([
                'title'                  => $data['title'],
                'surveyor_id'            => $data['surveyor_id'],
                'ngo_id'                 => $data['ngo_id'],
                'budget_cents'           => $data['budget_cents'],
                'remaining_budget_cents' => $data['remaining_budget_cents'],
                'payment_cents'          => $data['payment_cents'],
                'start_date'             => $data['start_date'],
                'end_date'               => $data['end_date'],
            ]);

            return $listener->savedSuccessfully($campaign);
        }
        catch (Exception $e)
        {
            return $listener->unableToSave($e->getMessage());
        }
    }

    private function guardAgainstInvalidParameters (array $parameters)
    {
        $validator = new Validator();

        $validator->make($parameters, self::$rules);

        if ($validator->fails())
        {
            $message = implode(', ', $validator->messages());

            throw new CampaignException($message);
        }
    }
}