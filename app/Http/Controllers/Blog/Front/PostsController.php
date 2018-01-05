<?php

namespace App\Http\Controllers\Blog\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use Meta;
use OpenGraph;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class PostsController extends BaseController
{

    /**
     * Vars
     */
    protected $posts, $categories, $tag, $user;

    /**
     * Construct
     */
    public function __construct(Post $posts, Category $categories, Tag $tag, User $user)
    {
      parent::__construct();
      $this->posts = $posts;
      $this->categories = $categories;
      $this->tag = $tag;
      $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
      $search = $request->get('q');
      $data = $this->posts->select('posts.id', 'posts.slug', 'posts.category_id', 'posts.card_type', 'posts.title', 'posts.subtitle', 'posts.user_id', 'posts.created_at')
                           ->where('posts.title', 'LIKE', '%'.$search.'%')
                           ->orWhere('posts.subtitle', 'LIKE', '%'.$search.'%')
                           ->orWhereHas('category', function($q) use ($search) {
                             $q->where('name', 'LIKE', '%'.$search.'%');
                           })
                           ->orWhereHas('tags', function($q) use ($search) {
                             $q->where('name', 'LIKE', '%'.$search.'%');
                           })
                           ->orWhereHas('user', function($q) use ($search) {
                             $q->whereRaw("concat(first_name, ' ', last_name) like '%$search%'");
                           })
                           ->orderBy('created_at', 'desc')
                           ->with('user','category');

      if($request->ajax()):
        $posts = $data->get();
        return view('blog.front.posts.list', compact('posts'));
      else:
        $posts = $data->paginate(9);
        return view('blog.front.posts.index', compact('posts'));
      endif;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Get posts
      $posts = $this->posts->orderBy('created_at', 'desc')
                           ->select('id', 'slug', 'category_id', 'card_type', 'title', 'subtitle', 'user_id', 'created_at')
                           ->with('user','category')
                           ->paginate(9);
      // Set seo tags
      Meta::setTitle('Mais recentes');
      Meta::setDescription('Quer se aprovado na OAB? Confira nossos posts mais recentes.');
      Meta::setKeywords('posts recentes, posts mais recentes, recentes, blog, oab');
      OpenGraph::setTitle('Mais recentes');
      OpenGraph::setDescription('Quer se aprovado na OAB? Confira nossos posts mais recentes.');
      OpenGraph::addImage(asset('/assets/images/facebook.jpg'));
      // Return view index with posts
      return view('blog.front.posts.index', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function popular(){
      // Get posts
      $posts = $this->posts->orderBy('visits', 'desc')
                           ->select('id', 'slug', 'category_id', 'card_type', 'title', 'subtitle', 'user_id', 'created_at')
                           ->with('user','category')
                           ->paginate(9);
      // Set seo tags
      Meta::setTitle('Posts populares');
      Meta::setDescription('Todo mundo quer saber o segredo, confira nossos posts populares.');
      Meta::setKeywords('posts populares, blog, popular, oab');
      OpenGraph::setTitle('Posts populares');
      OpenGraph::setDescription('Todo mundo quer saber o segredo, confira nossos posts populares.');
      OpenGraph::addImage(asset('/assets/images/facebook.jpg'));
      // Return view index with posts
      return view('blog.front.posts.index', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function category($category){
      // Find category where slug = $category
      $category = $this->categories->select('id', 'name', 'slug', 'color')->where('slug', '=', $category)->firstOrFail();
      // Get posts paginate
      $posts = $category->posts()
                        ->orderBy('created_at', 'desc')
                        ->select('id', 'slug', 'category_id', 'card_type', 'title', 'subtitle', 'user_id', 'created_at')
                        ->with('user','category')
                        ->paginate(9);
      // Set seo tags
      Meta::setTitle($category->seo->meta_title);
      Meta::setDescription($category->seo->meta_description);
      Meta::setKeywords($category->seo->meta_keywords);
      OpenGraph::setTitle($category->seo->meta_title);
      OpenGraph::setDescription($category->seo->meta_description);
      OpenGraph::addImage(asset('/assets/images/facebook.jpg'));
      // Return view index with posts
      return view('blog.front.posts.index', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function author($user){
      // Find user where slug = $user
      $user = $this->user->select('id', 'first_name', 'last_name', 'slug')->where('slug', '=', $user)->firstOrFail();
      // Get posts paginate
      $posts = $user->posts()
                    ->orderBy('created_at', 'desc')
                    ->select('id', 'slug', 'category_id', 'card_type', 'title', 'subtitle', 'user_id', 'created_at')
                    ->with('user','category')
                    ->paginate(9);
      // Set seo tags
      Meta::setTitle('Posts de ' . $user->full_name);
      Meta::setDescription('Confira os posts de ' . $user->full_name . '.');
      Meta::setKeywords($user->full_name);
      OpenGraph::setTitle('Posts de ' . $user->full_name);
      OpenGraph::setDescription('Confira os posts de ' . $user->full_name . '.');
      OpenGraph::addImage(asset('/assets/images/facebook.jpg'));
      // Return view index with posts
      return view('blog.front.posts.index', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tag($tag){
      // Find tag where slug = $tag
      $tag = $this->tag->select('id', 'name', 'slug')->where('slug', '=', $tag)->firstOrFail();
      // Get posts paginate
      $posts = $tag->posts()
                    ->orderBy('created_at', 'desc')
                    ->select('id', 'slug', 'category_id', 'card_type', 'title', 'subtitle', 'user_id', 'created_at')
                    ->with('user','category')
                    ->paginate(9);
      // Set seo tags
      Meta::setTitle('Tag: ' . $tag->name);
      Meta::setDescription('Confira nosso conteúdo completo sobre: ' . $tag->name . '.');
      Meta::setKeywords($tag->name);
      OpenGraph::setTitle('Tag: ' . $tag->name);
      OpenGraph::setDescription('Confira nosso conteúdo completo sobre: ' . $tag->name . '.');
      OpenGraph::addImage(asset('/assets/images/facebook.jpg'));
      // Return view index with posts
      return view('blog.front.posts.index', compact('posts'));
    }

    /**
     * Display a post.
     */
    public function view($category, $slug, $id){
      $category = $this->categories->where('slug', '=', $category)->firstOrFail();
      if ($category):
        // Find post
        $post = $this->posts->where('slug', '=', $slug)->where('id', '=', $id)->where('category_id', '=', $category->id)->firstOrFail();
        $post->increment('visits');
        // Set seo tags
        Meta::setTitle($post->seo->meta_title . ' | ' . $category->name);
        Meta::setDescription($post->seo->meta_description);
        Meta::setKeywords($post->seo->meta_keywords);
        OpenGraph::setTitle($post->seo->meta_title . ' | ' . $category->name);
        OpenGraph::setDescription($post->seo->meta_description);
        if ($post->image):
          OpenGraph::addImage(asset($post->image->getUrl('cover')));
        else:
          OpenGraph::addImage(asset('/assets/images/facebook.jpg'));
        endif;

        // Recommended Posts
        $recommended = $this->posts->where('id', '!=', $post->id)->orderBy('created_at', 'desc')->limit('3')->get();
        // Return view
        return view('blog.front.posts.view', compact('post', 'recommended'));
      endif;
    }

}
