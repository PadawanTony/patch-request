<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/22/16
 */

namespace App\Controllers\Auth;

use App\Http\Requests\Auth\Campaigns\Questions\StoreQuestionRequest;
use App\Http\Requests\Auth\Campaigns\Questions\UpdateQuestionRequest;
use App\Socialike\Campaign\Campaign;
use App\Socialike\Element\Element;
use App\Socialike\Question\Question;
use App\Socialike\QuestionValue\QuestionValue;
use Core\flash\Flash;
use Core\Request;
use Core\Response as HttpResponse;

class CampaignQuestionsController extends AuthController
{
    public function index (Campaign $campaign)
    {
        return $this->view('auth.campaigns.questions.index', compact('campaign'));
    }

    public function create (Campaign $campaign)
    {
        $elements = Element::all(['id', 'type'])->pluck('id', 'type');

        return $this->view('auth.campaigns.questions.create', compact('campaign', 'elements'));
    }

    public function store (Campaign $campaign, StoreQuestionRequest $request)
    {
        $questionData = array_merge([Question::CAMPAIGN_ID => $campaign->id], Request::only([
            Question::ELEMENT_ID,
            Question::QUERY,
            Question::PRIORITY,
        ]));

        $question = Question::create($questionData);

        $questionValues = explode(',', Request::get('question_values_text'));

        foreach ($questionValues as $questionValue)
        {
            QuestionValue::create([
                QuestionValue::QUESTION_ID => $question->id,
                QuestionValue::TEXT        => $questionValue,
            ]);
        }

        Flash::success('Question created.');

        return HttpResponse::redirect("/campaigns/$campaign->id/questions/$question->id/edit");
    }

    public function edit (Campaign $campaign, Question $question)
    {
        $elements = Element::all(['id', 'type'])->pluck('id', 'type');

        $values = implode(',', $question->activeValues()->pluck(QuestionValue::ID, QuestionValue::TEXT));

        return $this->view('auth.campaigns.questions.edit', compact('campaign', 'question', 'elements', 'values'));
    }

    public function update (Campaign $campaign, Question $question, UpdateQuestionRequest $request)
    {
        $question = Question::where([Question::ID => $question->id])->update(Request::only([
            Question::ELEMENT_ID,
            Question::QUERY,
            Question::PRIORITY,
        ]));

        $newValues = explode(',', Request::get('question_values_text'));

        $values = $question->values();

        foreach ($values as $value)
        {
            if ( ! in_array($value->text, $newValues))
            {
                QuestionValue::where([QuestionValue::ID => $value->id])
                    ->update([QuestionValue::IS_ACTIVE => '0']);
            }
        }

        foreach ($newValues as $newValue)
        {
            QuestionValue::create([
                QuestionValue::QUESTION_ID => $question->id,
                QuestionValue::TEXT        => $newValue,
            ]);
        }
        Flash::success('Question updated.');

        return HttpResponse::redirect("/campaigns/$campaign->id/questions/$question->id/edit");
    }
}