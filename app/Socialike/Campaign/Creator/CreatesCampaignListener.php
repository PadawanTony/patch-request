<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/10/16
 */

namespace App\Socialike\Campaign\Creator;


use App\Socialike\Model\Modeling;

interface CreatesCampaignListener
{
    /**
     * @param Modeling $campaign
     *
     * @return mixed
     */
    public function savedSuccessfully (Modeling $campaign);

    /**
     * @param $errorMessage
     *
     * @return mixed
     */
    public function unableToSave ($errorMessage);
}