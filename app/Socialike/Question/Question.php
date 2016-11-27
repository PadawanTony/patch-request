<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Socialike\Question;

use App\Socialike\Campaign\Campaign;
use App\Socialike\Element\Element;
use App\Socialike\Model\Model;
use App\Socialike\QuestionValue\QuestionValue;

class Question extends Model
{
    const TABLE = 'questions';
    const QUESTION_ID = 'question_id';
    const CAMPAIGN_ID = 'campaign_id';

    const ELEMENT_ID = 'element_id';
    const QUERY = 'query';
    const PRIORITY = 'priority';
    const ID = 'id';

    public $id;
    public $text;

    /**
     * @var Element
     */
    protected $element;
    protected $campaign;
    protected $question;
    protected $values;
    protected $activeValues;

    /**
     * Get the columns a user can fill. Don't put primary or foreigns key here!
     *
     * @return mixed
     */
    public static function columns ()
    {
        // TODO: Implement fillable() method.
    }

    /**
     * @return Element|false
     */
    public function element ()
    {
        if (empty($this->element))
        {
            $this->element = Element::where(['id' => $this->element_id])->first();
        }

        return $this->element;
    }

    public function campaign ()
    {
        if (empty($this->campaign))
        {
            $this->campaign = Campaign::where(['id' => $this->campaign_id])->first();
        }

        return $this->campaign;
    }

    public function values ()
    {
        if (empty($this->values))
        {
            $this->values = QuestionValue::where(['question_id' => $this->id])->all();
        }

        return $this->values;
    }

    public function activeValues ()
    {
        if (empty($this->activeValues))
        {
            $this->activeValues = QuestionValue::where([QuestionValue::QUESTION_ID => $this->id,])
                ->where([QuestionValue::IS_ACTIVE => '1'])
                ->all();
        }

        return $this->activeValues;
    }
}