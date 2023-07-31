<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QuestionAndAns;

class HelpAndSupportController extends Controller
{
    public function question_ans()
    {
        $help_support = QuestionAndAns::get();

        $response = [
            'question_and_ans' => $help_support,
        ];
        return response()->json($response);
    }
}
