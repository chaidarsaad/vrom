<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Item;
use App\Models\Question;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        $items = Item::with(['type', 'brand'])->get();
        $brands = Brand::all();
        $questions = Question::all();
        $hero = Item::with(['type', 'brand'])->latest()->first();

        return view('catalog', [
            'items' => $items,
            'questions' => $questions,
            'brands' => $brands,
            'hero' => $hero
        ]);
    }

    public function detail(Request $request, $slug)
    {
        $questions = Question::all();
        $brand = Brand::where('slug', $slug)->firstOrFail();
        $items = Item::where('brand_id', $brand->id)->paginate($request->input('limit', 12));
        $hero = Item::with(['type', 'brand'])->latest()->first();

        return view('catalogdetail', [
            'brand' => $brand,
            'items' => $items,
            'questions' => $questions,
            'hero' => $hero
        ]);
    }
}
