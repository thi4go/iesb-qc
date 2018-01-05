<?php

namespace App\Http\Controllers\Blog\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Validators\ContactValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Crumbs;
use Config;
use Mail;
use Meta;
use OpenGraph;

class ContactsController extends BaseController
{

    /**
     * @var [type]
     */
    protected $validator;

    /**
     * @var [type]
     */
    protected $contact;

    /**
     * Construct
     */
    public function __construct(ContactValidator $validator, Contact $contact)
    {
        // Validator
        $this->validator = $validator;
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
        // Set seo tags
        Meta::setTitle('Contato');
        Meta::setDescription('Entre em contato conosco.');
        Meta::setKeywords('fale conosco, contato');
        OpenGraph::setTitle('Entre em contato conosco.');
        OpenGraph::setDescription('Entre em contato conosco.');
        // Set breadcrumbs
        Crumbs::addCurrent('Contato');
        // Return view index
        return view('blog.front.contacts.index');
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
            // Create contact
            $contact = $this->contact->create($data);
            // Send message to mail
            $sent = Mail::send('blog.front.emails.contact', compact('contact'), function($m) use ($contact) {
                $m->to(Config::get('settings.app.email.default'))
                  ->from($contact->email, $contact->name)
                  ->subject($contact->subject);
            });
            // Success alert
            flash()->success("Mensagem enviada com sucesso.");
            // Redirect to pages index
            return redirect()->route('contacts.index');
        } catch(ValidatorException $e) {
            // Error alert
            flash()->error('Verifique os erros no formulário.');
            // Redirect to back page with validation errors
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

}
