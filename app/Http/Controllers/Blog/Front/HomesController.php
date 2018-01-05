<?php

namespace App\Http\Controllers\Blog\Front;

use Meta;
use OpenGraph;
use App\Models\Post;

class HomesController extends BaseController
{

    /**
     * Construct
     */
    public function __construct(Post $posts)
    {
      parent::__construct();
      $this->posts = $posts;
    }

    /**
     * Display Home
     * @return [type] [description]
     */
    public function index()
    {
      // Set seo tags
      // Meta::setTitle('Home');
      Meta::setDescription('Tornar o estudo simples e eficiente para que pessoas comuns sejam aprovadas no Exame da OAB é a nossa missão.');
      Meta::setKeywords('exame, prova, teste, exame da oab');
      OpenGraph::setTitle('Blog Exame da OAB');
      OpenGraph::setDescription('Tornar o estudo simples e eficiente para que pessoas comuns sejam aprovadas no Exame da OAB é a nossa missão.');
      OpenGraph::addImage(asset('/assets/images/facebook.jpg'));
      // Get releases
      $releases = $this->posts->select('id', 'slug', 'category_id', 'title', 'subtitle', 'user_id', 'created_at')
                           ->with('category')
                           ->where('release', true)
                           ->orderBy('id', 'desc')
                           ->limit(5)
                           ->get();

      // Get all releases ids
      $releasesIds = $releases->pluck('id');

      // Get posts
      $posts = $this->posts->select('id', 'slug', 'category_id', 'card_type', 'title', 'subtitle', 'user_id', 'created_at')
                           ->with('user','category')
                           ->whereNotIn('id', $releasesIds)
                           ->orderBy('id', 'desc')
                           ->limit(9)
                           ->get();

      // Return view index
      return view('blog.front.homes.index', compact('releases', 'posts'));
    }

}
