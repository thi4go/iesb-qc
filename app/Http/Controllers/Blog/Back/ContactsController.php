<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Crumbs;

class ContactsController extends PainelController
{

    /**
     * @var [type]
     */
    protected $contact;

    /**
     * Construct
     */
    public function __construct(Contact $contact)
    {
        // Middlewares
        $this->middleware('sentinel.access:painel.contacts.read', ['only' => ['index', 'show']]);
        // Repositories
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all contacts order by created_at desc
        $data = $this->contact->orderBy('id','desc')->paginate(5);
        // Set breadcrumbs
        Crumbs::addCurrent('Mensagens');
        // Return view index
        return view('blog.back.contacts.index', compact('data'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Find message by id
        $data = $this->contact->find($id);
        // Set breadcrumbs
        Crumbs::add(route('painel.contacts.index'), 'Mensagens');
        Crumbs::addCurrent('Visualizar Mensagem');
        // Return view index
        return view('blog.back.contacts.show', compact('data'));
    }

}
