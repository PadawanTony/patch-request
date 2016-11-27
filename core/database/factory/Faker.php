<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/20/16
 */

namespace Core\database\factory;

use App\Socialike\App\App;
use App\Socialike\Campaign\Campaign;
use App\Socialike\Element\Element;
use App\Socialike\Model\Model;
use App\Socialike\Ngo\Ngo;
use App\Socialike\Question\Question;
use App\Socialike\QuestionValue\QuestionValue;
use App\Socialike\Responder\Responder;
use App\Socialike\Response\Response;
use App\Socialike\User\User;

class Faker
{
    public static function response (array $data = [])
    {
        return Response::create([
            Response::QUESTION_ID       => self::question()->id,
            Response::QUESTION_VALUE_ID => self::questionValue()->id,
            Response::RESPONDER_ID      => self::responder()->id,
            Response::TEXT_RESPONSE     => faker()->paragraph,
        ]);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public static function question (array $data = [])
    {
        return Question::create([
            Question::QUERY       => faker()->sentence,
            Question::CAMPAIGN_ID => self::campaign()->id,
            Question::ELEMENT_ID  => self::element()->id,
        ]);
    }

    public static function campaign (array $data = [])
    {
        $campaign = Campaign::create([
            'surveyor_id'            => self::user()->id,
            'title'                  => faker()->word,
            'start_date'             => faker()->dateTime->format('Y-m-d H:m:s'),
            'end_date'               => faker()->dateTime->format('Y-m-d H:m:s'),
            'description'            => faker()->sentence,
            'ngo_id'                 => self::ngo()->id,
            'budget_cents'           => faker()->numberBetween(),
            'remaining_budget_cents' => faker()->numberBetween(),
            'payment_cents'          => faker()->numberBetween(),
        ]);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public static function user (array $data = [])
    {
        return User::create(['email' => faker()->unique()->email, 'password' => faker()->uuid,]);
    }

    /**
     * @param array $data
     *
     * @return Model
     */
    public static function ngo (array $data = [])
    {
        if (empty($data))
        {
            return Ngo::create(['name' => faker()->unique()->word]);
        }

        return Ngo::create($data);
    }

    public static function element (array $data = [])
    {
        return Element::first();
    }

    public static function questionValue ()
    {
        return QuestionValue::create([
            QuestionValue::QUESTION_ID => self::question()->id,
            QuestionValue::TEXT        => faker()->sentence,
        ]);
    }

    public static function responder ()
    {
        return Responder::create([
            Responder::APP_ID      => self::app()->id,
            Responder::MOBILE_UUID => faker()->uuid,
            Responder::BIRTHDATE   => faker()->dateTime->format(DATABASE_DATE_FORMAT),
            Responder::GENDER      => GENDER_FEMALE,
            Responder::EMAIL       => faker()->unique()->email,
            Responder::LOCATION    => faker()->address,
        ]);
    }

    public static function app ()
    {
        return App::create([
            App::OWNER_ID => self::user()->id,
            App::TOKEN    => faker()->uuid,
            App::NAME     => faker()->unique()->word,
        ]);
    }

    public static function campaignNike (array $data = [])
    {
        $campaigns = json_decode(file_get_contents(__DIR__ . '/business.json'));

        $inputCampaign = $campaigns[ array_rand($campaigns) ];

        $campaign = Campaign::create([
            'surveyor_id'            => self::user()->id,
            'title'                  => $inputCampaign->title,
            'start_date'             => faker()->dateTime->format('Y-m-d H:m:s'),
            'end_date'               => faker()->dateTime->format('Y-m-d H:m:s'),
            'description'            => $inputCampaign->description,
            'ngo_id'                 => self::ngo(['name' => $inputCampaign->ngo])->id,
            'budget_cents'           => faker()->numberBetween(),
            'remaining_budget_cents' => faker()->numberBetween(),
            'payment_cents'          => faker()->numberBetween(),
        ]);

        $inputQuestions = $inputCampaign->questions;

        foreach ($inputQuestions as $question)
        {
            $values = $question->values;

            $element = Element::where(['type' => $question->type])->first();

            $question = Question::create([
                'query'       => $question->query,
                'campaign_id' => $campaign->id,
                'element_id'  => $element->id,
            ]);

            foreach ($values as $value)
            {
                QuestionValue::create(['question_id' => $question->id, 'text' => $value]);
            }
        }
    }
}