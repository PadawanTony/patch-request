<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/20/16
 */

namespace App\Socialike\QuestionValue;

use App\Socialike\Model\Model;

class QuestionValue extends Model
{
    const TABLE = 'question_values';
    const QUESTION_ID = 'question_id';
    const TEXT = 'text';
    const ID = 'id';
    const IS_ACTIVE = 'is_active';

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    public static function columns ()
    {
        // TODO: Implement columns() method.
    }
}