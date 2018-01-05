<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\ActivityLog;
use App\Validators\UserValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Sentinel;
use Crumbs;

class AccountController extends PainelController
{

    /**
     * @var [type]
     */
    protected $validator;

    /**
     * @var [type]
     */
    protected $log;

    /**
     * Construct
     */
    public function __construct(UserValidator $validator, ActivityLog $log)
    {
        // Validator
        $this->validator = $validator;
        // Repositories
        $this->users = Sentinel::getUserRepository();
        $this->log = $log;
    }

    /**
     * Display user profile
     */
    public function index()
    {
        // Get user data
        $data = Sentinel::getUser();
        // Get 10 lasts logs order by created_at desc
        $logs = $this->log->where('user_id', $data->id)->orderBy('created_at','desc')->take(10)->get();
        // Set breadcrumbs
        Crumbs::addCurrent('Meu Perfil');
        // Return view index
        return view('blog.back.account.index', compact('data', 'logs'));
    }

    /**
     * Display user profile form edit
     */
    public function edit()
    {
        // Get user
        $data = Sentinel::getUser();
        // Set breadcrumbs
        Crumbs::add(route('painel.account.index'), 'Meu Perfil');
        Crumbs::addCurrent('Editar Perfil');
        // Return view edit
        return view('blog.back.account.edit', compact('data'));
    }

    /**
     * Update user profile
     */
    public function update(Request $request)
    {
        // Get current user id
        $id = Sentinel::getUser()->id;
        // Set data
        $data = $request->except('email','roles','avatar');
        $avatar = $request->file('avatar');
        // Save or fail
        try {
            // Unset password of $data if not send
            if(!$data['password'] && !$data['password_confirmation']):
                unset($data['password']);
                unset($data['password_confirmation']);
            endif;
            // Validate $data
            $this->validator->with($data)->setId($id)->passesOrFail('profile');
            // Update user
            $this->users->update($id, $data);
            if ($avatar):
                $user = $this->users->find($id);
                $user->clearMediaCollection('avatar');
                $filename = md5($avatar->getClientOriginalName()) . '.' . $avatar->getClientOriginalExtension();
                $user->addMedia($avatar)->usingName($user->first_name)->usingFileName($filename)->toCollection('avatar');
            endif;
            // Success alert
            flash()->success('Seu perfil foi atualizado.');
            // Redirect to user profile
            return redirect()->route('painel.account.index');
        } catch(ValidatorException $e) {
            // Error alert
            flash()->error('Verifique os erros no formulário.');
            // Redirect to back page with validation errors
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

}
