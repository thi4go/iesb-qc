<?php

namespace App\Http\Controllers\Blog\Front;

use Illuminate\Http\Request;

use App;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class SitemapsController extends Controller
{

    /**
     * Vars
     */
    protected $posts, $categories, $tags, $users;

    /**
     * Construct
     */
    public function __construct(Post $posts, Category $categories, Tag $tags, User $users)
    {
      $this->posts = $posts;
      $this->categories = $categories;
      $this->tags = $tags;
      $this->users = $users;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sitemap = App::make("sitemap");

        // Add home page to sitemap
        $sitemap->add(route('homes.index'), '2016-05-04T20:10:00+02:00', '1.0', 'daily');

        // Add posts recents to sitemap
        $sitemap->add(route('posts.recent'), '2016-05-04T20:10:00+02:00', '1.0', 'daily');

        // Add posts recents to sitemap
        $sitemap->add(route('posts.popular'), '2016-05-04T20:10:00+02:00', '1.0', 'daily');

        // Get all categories
        $categories = $this->categories->select('id', 'slug', 'updated_at')->orderBy('id', 'desc')->get();

        // Add categories to sitemap
        foreach ($categories as $category)
            $sitemap->add(route('posts.category', ['category' => $category->slug]), $category->updated_at, '0.9', 'monthly');

        // Get all posts
        $posts = $this->posts->select('id', 'category_id', 'slug', 'updated_at')->with('category')->orderBy('id', 'desc')->get();

        // Add posts to sitemap
        foreach ($posts as $post)
            $sitemap->add(route('posts.view', ['category' => $post->category->slug, 'slug' => $post->slug, 'id' => $post->id]), $post->updated_at, '0.8', 'monthly');

        // Get all tags
        $tags = $this->tags->select('id', 'slug', 'updated_at')->orderBy('id', 'desc')->get();

        // Add tags to sitemap
        foreach ($tags as $tag)
            $sitemap->add(route('posts.tag', ['tag' => $tag->slug]), $tag->updated_at, '0.8', 'monthly');

        // Get all users
        $users = $this->users->select('id', 'slug')->orderBy('id', 'desc')->get();

        // Add users to sitemap
        foreach ($users as $user)
            $sitemap->add(route('posts.author', ['user' => $user->slug]), '2016-05-04T20:10:00+02:00', '0.8', 'monthly');

        // Return sitemap
        return $sitemap->render('xml');
    }

}
