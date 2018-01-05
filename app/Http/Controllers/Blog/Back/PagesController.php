<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Validators\PageValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Crumbs;
use Sentinel;
use Activity;

class PagesController extends PainelController
{

    /**
     * @var [type]
     */
    protected $validator;

    /**
     * @var [type]
     */
    protected $page;

    /**
     * Construct
     */
    public function __construct(PageValidator $validator, Page $page)
    {
        // Middlewares
        $this->middleware('sentinel.access:painel.pages.read', ['only' => ['index']]);
        $this->middleware('sentinel.access:painel.pages.write', ['only' => ['create', 'edit', 'destroy']]);
        // Validator
        $this->validator = $validator;
        // Entities
        $this->page = $page;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all pages order by id desc
        $data = $this->page->orderBy('id','desc')->paginate(10);
        // Set breadcrumbs
        Crumbs::addCurrent('Páginas');
        // Return view index
        return view('blog.back.pages.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Set breadcrumbs
        Crumbs::add(route('painel.pages.index'), 'Páginas');
        Crumbs::addCurrent('Adicionar Página');
        // Return view create
        return view('blog.back.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Set data
        $data = $request->all();
        // Save or fail
        try {
            // Validate $data
            $this->validator->with($data)->passesOrFail();
            // Create page and seo tags
            $page = $this->page->create($data);
            $page->seo()->create($data);
            // Create log
            Activity::log([
                'contentId'   => $page->id,
                'contentType' => 'page',
                'action'      => 'create',
                'description' => 'criou a página',
                'details'     => $page->title
            ]);
            // Success alert
            flash()->success("Página <b>{$page->title}</b> criada com sucesso.");
            // Redirect to pages index
            return redirect()->route('painel.pages.index');
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
        // Find role
        $data = $this->page->find($id);
        // Set breadcrumbs
        Crumbs::add(route('painel.pages.index'), 'Páginas');
        Crumbs::addCurrent('Editar Página');
        // Return view edit
        return view('blog.back.pages.edit', compact('data'));
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
        // Set data
        $data = $request->all();
        // Save or fail
        try {
            // Validate $data
            $this->validator->with($data)->setId($id)->passesOrFail();
            // Update page by id
            $this->page->findOrFail($id)->update($data);
            $page = $this->page->findOrFail($id);
            $page->seo->fill($data)->save();
            // Create log
            Activity::log([
                'contentId'   => $page->id,
                'contentType' => 'page',
                'action'      => 'update',
                'description' => 'atualizou a página',
                'details'     => $page->title
            ]);
            // Success alert
            flash()->success("Página <b>{$page->title}</b> atualizada com sucesso.");
            // Redirect to pages index
            return redirect()->route('painel.pages.index');
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
        // Find page by id
        if ($page = $this->page->find($id)):
            // Delete page
            $page->delete();
            $page->seo->delete();
            // Create log
            Activity::log([
                'contentId'   => $page->id,
                'contentType' => 'page',
                'action'      => 'delete',
                'description' => 'excluiu a página',
                'details'     => $page->title
            ]);
            // Success alert
            flash()->success("Página <b>{$page->title}</b> excluída com sucesso.");
        endif;
        // Redirect to pages index
        return redirect()->route('painel.pages.index');
    }

}
