<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Category;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Validators\CategoryValidator;
use Crumbs;
use Sentinel;
use Activity;

class CategoriesController extends PainelController
{

    protected $category, $validator;

    public function __construct(Category $category, CategoryValidator $validator)
    {
      // Middlewares
      $this->middleware('sentinel.access:painel.categories.read', ['only' => ['index']]);
      $this->middleware('sentinel.access:painel.categories.write', ['only' => ['create', 'edit', 'destroy']]);

      $this->validator = $validator;
      $this->category = $category;
    }

    public function index()
    {
      // Get all categories
      $data = $this->category->orderBy('id', 'desc')->paginate(10);
      // Set breadcrumbs
      Crumbs::addCurrent('Categorias');
      // Return view index
      return view('blog.back.categories.index', compact('data'));
    }

    public function create()
    {
      return view('blog.back.categories.create');
    }

    public function store(Request $request)
    {
      $data = $request->all();
      try{
        // Validate $data
        $this->validator->with($data)->passesOrFail();
        $category = $this->category->create($data);
        $category->seo()->create($data);
        // Create log
        Activity::log([
          'contentId'   => $category->id,
          'contentType' => 'category',
          'action'      => 'create',
          'description' => 'criou a categoria',
          'details'     => $category->name
        ]);
        // Success alert
        flash()->success("Categoria <b>{$category->name}</b> criada com sucesso.");
        // Redirect to leads index
        return redirect()->route('painel.categories.index');
      } catch(ValidatorException $e) {
        // Error alert
        flash()->error('Verifique os erros no formulário.');
        // Redirect to back page with validation errors
        return redirect()->back()->withInput()->withErrors($e->getMessageBag());
      }
    }

    public function edit($id)
    {
        // Find category
        $data = $this->category->findOrFail($id);
        // Set breadcrumbs
        Crumbs::add(route('painel.categories.index'), 'Categorias');
        Crumbs::addCurrent('Editar Categoria');
        // Return view edit
        return view('blog.back.categories.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
      $data = $request->all();
      try{
        // Validate $data
        $this->validator->with($data)->setId($id)->passesOrFail();
        $category = $this->category->findOrFail($id);
        $category->update($data);
        $category->seo->fill($data)->save();
        // Create log
        Activity::log([
          'contentId'   => $category->id,
          'contentType' => 'category',
          'action'      => 'update',
          'description' => 'atualizou a categoria',
          'details'     => $category->name
        ]);
        // Success alert
        flash()->success("Categoria <b>{$category->name}</b> atualizada com sucesso.");
        // Redirect to leads index
        return redirect()->route('painel.categories.index');
      } catch(ValidatorException $e) {
        // Error alert
        flash()->error('Verifique os erros no formulário.');
        // Redirect to back page with validation errors
        return redirect()->back()->withInput()->withErrors($e->getMessageBag());
      }
    }

    public function destroy($id)
    {
      // Find category by id
      if ($category = $this->category->findOrFail($id)):
        // Delete category
        $category->delete();
        $category->seo->delete();
        // Create log
        Activity::log([
          'contentId'   => $category->id,
          'contentType' => 'category',
          'action'      => 'delete',
          'description' => 'excluiu a categoria',
          'details'     => $category->name
        ]);
        // Success alert
        flash()->success("Categoria <b>{$category->name}</b> excluída com sucesso.");
      endif;
      // Redirect to pages index
      return redirect()->route('painel.categories.index');
    }
}
