<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/22/16
 */

use App\Socialike\Element\Element;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../core/bootstrap/app.php';


$elements = [
    [
        Element::ID   => 1,
        Element::TAG  => Element::ELEMENT_TAG_INPUT,
        Element::TYPE => Element::ELEMENT_INPUT_TEXT_TYPE,
    ],
    [
        Element::ID   => 2,
        Element::TAG  => Element::ELEMENT_TAG_INPUT,
        Element::TYPE => Element::ELEMENT_INPUT_SELECT_TYPE,
    ],
    [
        Element::ID   => 3,
        Element::TAG  => Element::ELEMENT_TAG_INPUT,
        Element::TYPE => Element::ELEMENT_INPUT_CHECKBOX_TYPE,
    ],
    [
        Element::ID   => 4,
        Element::TAG  => Element::ELEMENT_TAG_INPUT,
        Element::TYPE => Element::ELEMENT_INPUT_RADIO_TYPE,
    ],
    [
        Element::ID   => 5,
        Element::TAG  => Element::ELEMENT_TAG_INPUT,
        Element::TYPE => Element::ELEMENT_INPUT_NUMBER_TYPE,
    ],
    [
        Element::ID  => 6,
        Element::TAG => Element::ELEMENT_TAG_TEXTAREA,
        Element::TYPE => Element::ELEMENT_TAG_TEXTAREA, // required for html generation.
    ],
];

foreach ($elements as $element)
{
    Element::create($element);
}
