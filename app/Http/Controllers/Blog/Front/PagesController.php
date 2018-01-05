<?php

namespace App\Http\Controllers\Blog\Front;

use App\Models\Page;
use Crumbs;
use Meta;
use OpenGraph;

class PagesController extends BaseController
{

    /**
     * @var [type]
     */
    protected $page;

    /**
     * Construct
     */
    public function __construct(Page $page)
    {
      // Repositories
      $this->page = $page;
    }

    /**
     Display page
     * @param  [type] $slug [description]
     * @return [type]       [description]
     */
    public function show($slug)
    {
      // Find page
      $data = $this->page->where('slug', $slug)->firstOrFail();
      // Set seo tags
      Meta::setTitle($data->seo->meta_title);
      Meta::setDescription($data->seo->meta_description);
      Meta::setKeywords($data->seo->meta_keywords);
      OpenGraph::setTitle($data->seo->meta_title);
      OpenGraph::setDescription($data->seo->meta_description);
      // Set breadcrumbs
      Crumbs::addCurrent($data->seo->meta_title);
      // Return view show
      return view('blog.front.pages.show', compact('data'));
    }

}
