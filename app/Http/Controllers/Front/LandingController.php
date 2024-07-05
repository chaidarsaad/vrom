<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Question;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $items = Item::with(['type', 'brand'])->oldest()->take(4)->get()->reverse();
        $questions = Question::all();
        $hero = Item::with(['type', 'brand'])->latest()->first();

        return view('landing', [
            'items' => $items,
            'questions' => $questions,
            'hero' => $hero
        ]);
    }
}
