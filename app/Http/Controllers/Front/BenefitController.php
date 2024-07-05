<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Question;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        $hero = Item::with(['type', 'brand'])->latest()->first();

        return view('benefit', [
            'questions' => $questions,
            'hero' => $hero
        ]);
    }
}
