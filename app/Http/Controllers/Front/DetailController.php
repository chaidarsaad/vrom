<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Question;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index($slug)
    {
        $questions = Question::all();
        $item = Item::with(['type', 'brand'])->where('slug', $slug)->firstOrFail();
        $similarItems = Item::with(['type', 'brand'])
            ->where('type_id', $item->type->id) // Menggunakan relasi 'type' dari $item
            ->where('id', '!=', $item->id)     // Agar tidak termasuk item yang sedang ditampilkan
            ->get();
        return view('detail', [
            'item'     => $item,
            'similarItems' => $similarItems,
            'questions' => $questions
        ]);
    }
}
