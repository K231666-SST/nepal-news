<?php
namespace App\Http\Controllers;
use App\Models\{Article, Event};

class HomeController extends Controller
{
    public function index() {
        $featured      = Article::featured()->with('author','tags')->latest('published_at')->take(3)->get();
        $breaking      = Article::breaking()->latest('published_at')->take(8)->get();
        $latest        = Article::published()->with('author','tags')->latest('published_at')->take(6)->get();
        $nepalNews     = Article::published()->byCategory('nepal')->with('author')->latest('published_at')->take(3)->get();
        $australiaNews = Article::published()->byCategory('australia')->with('author')->latest('published_at')->take(3)->get();
        $opinions      = Article::published()->byCategory('opinion')->with('author')->latest('published_at')->take(2)->get();
        $trending      = Article::published()->orderByDesc('views')->take(5)->get();
        $events        = Event::approved()->upcoming()->orderBy('event_date')->take(4)->get();
        return view('pages.home', compact('featured','breaking','latest','nepalNews','australiaNews','opinions','trending','events'));
    }
}
