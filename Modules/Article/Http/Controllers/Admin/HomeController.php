<?php

namespace Modules\Article\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class HomeController extends Controller
{
  public function index()
  {
    return view('article::admin.index');
  }
}