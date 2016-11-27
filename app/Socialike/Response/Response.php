<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/20/16
 */

namespace App\Socialike\Response;

use App\Socialike\Model\Model;
use App\Socialike\Question\Question;
use App\Socialike\Responder\Responder;

class Response extends Model
{
    const TABLE = 'responses';
    const QUESTION_ID = 'question_id';
    const QUESTION_VALUE_ID = 'question_value_id';
    const RESPONDER_ID = 'responder_id';
    const TEXT_RESPONSE = 'text_response';

    /**
     * @var Responder
     */
    protected $responder;
    /**
     * @var Question
     */
    protected $question;

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    public static function columns ()
    {
        // TODO: Implement columns() method.
    }

    public function responder ()
    {
        if (empty($this->responder))
        {
            $this->responder = Responder::where(['id' => $this->responder_id])->first();
        }

        return $this->responder;
    }

    public function question ()
    {
        if (empty($this->question))
        {
            $this->question = Question::where(['id' => $this->question_id])->first();
        }

        return $this->question;
    }
}