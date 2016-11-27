<?php declare(strict_types = 1);

namespace App\Socialike\Campaign;

use App\Socialike\Model\Collection;
use App\Socialike\Model\Model;
use App\Socialike\Question\Question;

/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/8/16
 */
class Campaign extends Model
{
    const TABLE = 'campaigns';
    const CAMPAIGN_ID = 'campaign_id';

    /**
     * @var Collection
     */
    protected $questions;

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    public static function columns ()
    {
        return [
            'title',
            'start_date',
            'end_date',
            'budget_cents',
            'remaining_budget_cents',
            'payment_cents',
            'description',
            'img_theme',
            'total_responses_goal',
            'coupon_code',
            'coupon_discount_rate',
            'total_coupons',
            'ngo_id',
            'surveyor_id',
        ];
    }

    /**
     * @return Collection
     */
    public function questions ()
    {
        if (empty($this->questions))
        {
            $this->questions = Question::where([self::CAMPAIGN_ID => $this->id])->all();
        }

        return $this->questions;
    }
}