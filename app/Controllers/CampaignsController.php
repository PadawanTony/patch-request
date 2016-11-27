<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/19/16
 */

namespace App\Controllers;

use App\Socialike\Campaign\Campaign;
use App\Socialike\Element\Element;
use App\Socialike\Faker;
use App\Socialike\Ngo\Ngo;
use App\Socialike\Question\Question;
use App\Socialike\QuestionValue\QuestionValue;
use App\Socialike\User\User;

/**
 * Class CampaignsController
 * @package App\Controllers
 */
class CampaignsController extends Controller
{
    /**
     * @return string
     */
    public function create ()
    {
        $campaign = Campaign::first();

        \Core\database\factory\Faker::campaign();
        return $this->view('guest.campaigns.create', compact('campaign'));
    }
}