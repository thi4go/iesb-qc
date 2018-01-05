<?php

namespace App\Http\Controllers\Blog\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class BaseController extends Controller
{

  /**
   * Vars
   */
  protected $tags, $categories;

  /**
   * Construct
   */
  public function __construct()
  {
    $tags = DB::table('tags')->select('id', 'name', 'slug')->get();
    $categories = DB::table('categories')->select('id', 'name', 'slug', 'color')->get();
    view()->share(compact('tags', 'categories'));
  }

}
