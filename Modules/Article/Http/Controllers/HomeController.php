<?php

namespace Modules\Article\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App;

class HomeController extends Controller
{
    public function __construct()
    {
        $paths = [public_path('templates/default')];
        \View::setFinder(new \Illuminate\View\FileViewFinder(\App::make('files'), $paths));
    }

    public function index()
    {
        return view('a');
    }
}
