<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Validators\PostValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Crumbs;
use Sentinel;
use Activity;

class PostsController extends PainelController
{

    /**
     * Vars
     */
    protected $validator, $post, $categories, $tags;

    /**
     * Construct
     */
    public function __construct(Post $post, Category $categories, Tag $tags, PostValidator $validator)
    {
      // Middlewares
      $this->middleware('sentinel.access:painel.roles.read', ['only' => ['index']]);
      $this->middleware('sentinel.access:painel.roles.write', ['only' => ['create', 'edit', 'destroy']]);

      $this->validator = $validator;
      $this->post = $post;
      $this->categories = $categories;
      $this->tags = $tags;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // Get all posts
      $data = $this->post->orderBy('id', 'desc')->paginate(10);
      // Set breadcrumbs
      Crumbs::addCurrent('Posts');
      // Return view index
      return view('blog.back.posts.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // Set breadcrumbs
      Crumbs::add(route('painel.posts.index'), 'Posts');
      Crumbs::addCurrent('Adicionar Post');
      // Categories
      $categories = $this->categories->pluck('name','id');
      // Return view
      return view('blog.back.posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data = $request->all();
      $data['user_id'] = Sentinel::check()->id;
      $image = $request->file('image');
      // Save or fail
      try {
        // Validate $data
        $this->validator->with($data)->passesOrFail();
        // Create post and seo tags
        $post = $this->post->create($data);
        // Sync tags
        $post->tags()->sync($this->getTagsIds($request->tags));
        $post->seo()->create($data);
        if ($image):
          $filename = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
          $post->addMedia($image)->usingFileName($filename)->toCollection('posts');
        endif;
        // Create log
        Activity::log([
          'contentId'   => $post->id,
          'contentType' => 'post',
          'action'      => 'create',
          'description' => 'criou o post',
          'details'     => $post->title
        ]);
        // Success alert
        flash()->success("Post <b>{$post->title}</b> criado com sucesso.");
        // Redirect to posts index
        return redirect()->route('painel.posts.index');
      } catch(ValidatorException $e) {
        // Error alert
        flash()->error('Verifique os erros no formulário.');
        // Redirect to back page with validation errors
        return redirect()->back()->withInput()->withErrors($e->getMessageBag());
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      // Find post
      $data = $this->post->findOrFail($id);
      // Categories
      $categories = $this->categories->pluck('name','id');
      // Set breadcrumbs
      Crumbs::add(route('painel.posts.index'), 'Posts');
      Crumbs::addCurrent('Editar Post');
      // Return view edit
      return view('blog.back.posts.edit', compact('data', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $data = $request->all();
      $image = $request->file('image');
      try{
        $this->validator->with($data)->setId($id)->passesOrFail();
        $post = $this->post->findOrFail($id);
        $post->update($data);
        $post->tags()->sync($this->getTagsIds($request->tags));
        if ($image):
          $post->clearMediaCollection('posts');
          $filename = md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
          $post->addMedia($image)->usingFileName($filename)->toCollection('posts');
        endif;
        $post->seo->fill($data)->save();
        // Create log
        Activity::log([
          'contentId'   => $post->id,
          'contentType' => 'post',
          'action'      => 'update',
          'description' => 'atualizou o post',
          'details'     => $post->title
        ]);
        // Success alert
        flash()->success("Post <b>{$post->title}</b> atualizado com sucesso.");
        // Redirect to posts index
        return redirect()->route('painel.posts.index');
      } catch(ValidatorException $e) {
        // Error alert
        flash()->error('Verifique os erros no formulário.');
        // Redirect to back page with validation errors
        return redirect()->back()->withInput()->withErrors($e->getMessageBag());
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      // Find post by id
      if ($post = $this->post->findOrFail($id)):
        // Delete post
        $post->delete();
        $post->seo->delete();
        // Create log
        Activity::log([
          'contentId'   => $post->id,
          'contentType' => 'post',
          'action'      => 'delete',
          'description' => 'excluiu o post',
          'details'     => $post->title
        ]);
        // Success alert
        flash()->success("Post <b>{$post->title}</b> excluído com sucesso.");
      endif;
      // Redirect to pages index
      return redirect()->route('painel.posts.index');
    }

    /**
     * Get Tags Ids
     */
    private function getTagsIds($tags) {
      $tagList = array_filter(array_map('trim', explode(',', $tags)));
      $tagsIDs = [];
      foreach ($tagList as $tagName):
        $tagsIDs[] = $this->tags->firstOrCreate(['name' => $tagName])->id;
      endforeach;
      return $tagsIDs;
    }

}
