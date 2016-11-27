<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/23/16
 */

namespace App\Http\Requests\Auth\Campaigns\Questions;


use App\Http\Requests\ValidateHttpRequest;

class UpdateQuestionRequest extends ValidateHttpRequest
{
    public function rules () : array
    {
        return [
            'element_id'           => 'required|exists:elements,id',
            'query'                => 'required|string',
            'priority'             => 'required|numeric|min:1',
            'question_values_text' => 'string',
        ];
    }
}