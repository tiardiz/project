<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return News::latest()->get();
    }

    public function show($id)
    {
        $news = News::with('comments')->findOrFail($id);
        $news->increment('views'); // +1 просмотр при открытии
        return $news;
    }

    public function like($id)
    {
        $news = News::findOrFail($id);
        $news->increment('likes'); // +1 лайк
        return response()->json(['likes' => $news->likes]);
    }
}

