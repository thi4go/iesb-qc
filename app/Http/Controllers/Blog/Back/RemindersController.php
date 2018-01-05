<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Validators\UserValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Sentinel;
use Reminder;
use Mail;

class RemindersController extends PainelController
{

    /**
     * @var [type]
     */
    protected $validator;

    /**
     * @var [type]
     */
    protected $users;

    /**
     * Construct
     */
    public function __construct(UserValidator $validator)
    {
        // Middlewares
        $this->middleware('sentinel.guest');
        // Validator
        $this->validator = $validator;
        // Repositories
        $this->users = Sentinel::getUserRepository();
    }

    /**
     * Display user reminder form
     */
    public function reminder()
    {
        // Return view reminder
        return view('blog.back.reminders.reminder');
    }

    /**
     * Send reset mail to user
     */
    public function remind(Request $request)
    {
        // Set data
        $data = $request->all();
        // Send or fail
        try {
            $this->validator->with($data)->passesOrFail('reminder_start');
            if ($user = $this->users->findByCredentials($data)):
                $reminder = Reminder::exists($user) ?: Reminder::create($user);
                $code = $reminder->code;
                $sent = Mail::send('blog.back.emails.reminder', compact('user', 'code'), function($m) use ($user) {
                    $m->to($user->email)
                      ->from('me@hugofabricio.com')
                      ->subject('Pedido de alteração de senha.');
                });
                flash()->success('O link de redefinição de senha foi enviado para o seu e-mail!');
            else:
                flash()->error('Não encontramos nenhum usuário com esse endereço de e-mail.');
            endif;
        }
        catch (ValidatorException $e) {
            flash()->error('Verifique os erros no formulário.');
        }
        return redirect()->back();
    }

    /**
     * Display reset password form
     */
    public function reset($id, $code)
    {
        $user = $this->users->findById($id);
        if($reminder = Reminder::exists($user, $code)):
            return view('back.reminders.reset', compact('id', 'code'));
        else:
            flash()->warning('Este token para recuperação de senha é inválido, solicite novamente.');
            return redirect()->route('painel.reminders.reminder');
        endif;
    }

    /**
     * Process password reset and redirect to login
     */
    public function processReset($id, $code, Request $request)
    {
        // Set data
        $data = $request->all();
        // Save or fail
        try {
            $this->validator->with($data)->passesOrFail('reminder_end');
            $user = $this->users->findById($id);
            if ($reminder = Reminder::complete($user, $code, array_get($data, 'password'))):
                flash()->success('Sua senha foi alterada!');
                return redirect()->route('painel.auth.login');
            else:
                flash()->error('Falha ao redefinir senha.');
                return redirect()->back();
            endif;
        }
        catch (ValidatorException $e) {
            flash()->error('Verifique os erros no formulário.');
            return redirect()->back()->withErrors($e->getMessageBag());
        }
    }

}
