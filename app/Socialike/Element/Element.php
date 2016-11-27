<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/11/16
 */

namespace App\Socialike\Element;

use App\Socialike\Model\Collection;
use App\Socialike\Model\Model;

class Element extends Model
{
    const TABLE = 'elements';
    const ID = 'id';

    const ELEMENT_INPUT_TEXT_TYPE = 'text';
    const ELEMENT_TAG_INPUT = 'input';
    const ELEMENT_TAG_TEXTAREA = 'textarea';
    const ELEMENT_INPUT_SELECT_TYPE = 'select';
    const ELEMENT_INPUT_RADIO_TYPE = 'radio';
    const ELEMENT_INPUT_CHECKBOX_TYPE = 'checkbox';
    const TAG = 'tag';
    const TYPE = 'type';
    const ELEMENT_INPUT_NUMBER_TYPE = 'number';

    public $type;

    /**
     * @var Collection
     */
    protected $questionValues;

    /**
     * Get the columns of the table.
     *
     * @return mixed
     */
    public static function columns ()
    {
    }

    /**
     * @return bool
     */
    public function tagIsTextArea () : bool
    {
        return $this->tag == self::ELEMENT_TAG_TEXTAREA;
    }

    /**
     * @return bool
     */
    public function tagIsInput () : bool
    {
        return $this->tag == self::ELEMENT_TAG_INPUT;
    }

    public function typeIsText ()
    {
        return $this->type == self::ELEMENT_INPUT_TEXT_TYPE;
    }

    public function typeIsSelect ()
    {
        return $this->type == self::ELEMENT_INPUT_SELECT_TYPE;
    }

    public function typeIsRadio ()
    {
        return $this->type == self::ELEMENT_INPUT_RADIO_TYPE;
    }

    public function typeIsCheckbox ()
    {
        return $this->type == self::ELEMENT_INPUT_CHECKBOX_TYPE;
    }
}