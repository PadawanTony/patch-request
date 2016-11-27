<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/20/16
 */

namespace App\Socialike\Element;

use App\Socialike\Question\Question;
use InvalidArgumentException;

class HtmlGenerator
{
    public function generate (Question $question)
    {
        $element = $question->element();

        if ($element->tagIsTextArea())
        {
            return $this->generateTextareaHtml($question);
        }

        if ($element->tagIsInput())
        {
            return $this->generateInputElement($question, $element);
        }

        throw new InvalidArgumentException("Invalid element tag: {$element->tag}");
    }

    /**
     * @param Question $question
     *
     * @return string
     */
    private function generateTextareaHtml (Question $question):string
    {
        $html = "<textarea id='question[{$question->id}]' class='materialize-textarea'></textarea>";

        return $html . $this->generateLabel($question);
    }

    /**
     * @param Question $question
     *
     * @return string
     */
    private function generateLabel (Question $question):string
    {
        return "<label for='question[$question->id]'>$question->query</label>";
    }

    /**
     * @param Question $question
     * @param          $element
     *
     * @return string
     */
    private function generateInputElement (Question $question, Element $element):string
    {
        if ($element->typeIsText())
        {
            return $this->generateText($question);
        }

        if ($element->typeIsSelect())
        {
            return $this->generateSelect($question);
        }

        if ($element->typeIsRadio())
        {
            return $this->generateRadio($question);
        }

        if ($element->typeIsCheckbox())
        {
            return $this->generateCheckbox($question);
        }

        throw new InvalidArgumentException("Invalid element input type: $element->type");
    }

    /**
     * @param Question $question
     *
     * @return string
     */
    private function generateText (Question $question):string
    {
        $html = "<input type='text' id='question[{$question->id}]' name='question[{$question->id}]' " .

            "class='materialize-textarea'/>";

        return $html . $this->generateLabel($question);
    }

    /**
     * @param Question $question
     *
     * @return string
     */
    private function generateSelect (Question $question):string
    {
        $html = "<select name='question[$question->id]' id='question[$question->id]'>";

        $html .= "<option value='' disabled selected>Choose your option</option>";

        $values = $question->values();

        foreach ($values as $value)
        {
            $html .= "<option value='$value->id'>{$value->text}</option>";
        }

        return $html . '</select>' . $this->generateLabel($question);
    }

    private function generateRadio (Question $question):string
    {
        $values = $question->values();

        $html = '<div class="input-field col s12">';

        foreach ($values as $value)
        {
            $html .= "<p><input name='question[$question->id]' type='radio' value='question_values[$value->id]' " .
                "id='question_values[$value->id]'/>";

            $html .= "<label for='question_values[$value->id]'>$value->text</label></p>";
        }


        return $html .  '</div>'. $this->generateLabel($question);
    }

    private function generateCheckbox ($question)
    {
        $values = $question->values();

        $html = '<div class="input-field col s12">';

        foreach ($values as $value)
        {
            $html .= "<p><input name='question[$question->id]' type='checkbox' value='question_values[$value->id]' " .
                "id='question_values[$value->id]'/>";

            $html .= "<label for='question_values[$value->id]'>$value->text</label></p>";
        }


        return $html .  '</div>'. $this->generateLabel($question);
    }
}