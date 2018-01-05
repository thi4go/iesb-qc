<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Validators\UserValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Sentinel;

class AuthController extends PainelController
{

    /**
     * @var [type]
     */
    protected $validator;

    /**
     * @var [type]
     */
    protected $sentinel;

    /**
     * Construct
     */
    public function __construct(UserValidator $validator)
    {
        // Middlewares
        $this->middleware('sentinel.guest', ['except' => 'logout']);
        // Validator
        $this->validator = $validator;
        // Sentinel
        $this->sentinel = app()->make('sentinel');
    }

    /**
     * Return view login
     * @return [type] [description]
     */
    public function authenticate()
    {
        // Return view login
        return view('blog.back.auth.login');
    }

    /**
     * Process login
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function login(Request $request)
    {
        try {
            // Get credentials
            $credentials = $request->only('email','password');
            // Validate $credentials
            $this->validator->with($credentials)->passesOrFail('auth');
            // Get remember value
            $remember = (bool)$request->get('remember', false);
            // If authenticate redirect to /painel
            if ($this->sentinel->authenticate($credentials, $remember)):
                return redirect()->intended('painel');
            endif;
            // Error alert
            flash()->error('Usuário ou senha inválidos.');
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $e) {
            // Error alert
            flash()->error('Sua conta está desativada!');
        } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $e) {
            // Get seconds delay
            $delay = $e->getDelay();
            // Error alert
            flash()->error("Muitas tentativas de login. Por favor tente novamente em <b>{$delay}</b> segundo(s).");
        } catch(ValidatorException $e) {
            // Error alert
            flash()->error('Verifique os erros abaixo.');
            // Redirect to back page with validation errors
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
        // Redirect same page with errors
        return redirect()->back()->withInput();
    }

    /**
     * Process logout
     * @return [type] [description]
     */
    public function logout()
    {
        // Logout user
        Sentinel::logout();
        // Return login page
        return redirect()->route('painel.auth.login');
    }

}
