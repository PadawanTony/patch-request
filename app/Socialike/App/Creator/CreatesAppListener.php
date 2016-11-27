<?php
/**
 * @author Anthony Kalogeropoulos <anthonykalogeropoulos@gmail.com>
 * @since  11/10/16
 */

namespace App\Socialike\App\Creator;


use App\Socialike\Model\Modeling;

interface CreatesAppListener
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