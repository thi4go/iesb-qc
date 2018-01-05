<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Validators\UserValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Crumbs;
use Sentinel;
use Activation;
use Activity;
use Permission;

class UsersController extends PainelController
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
     * @var [type]
     */
    protected $roles;

    /**
     * Construct
     */
    public function __construct(UserValidator $validator)
    {
        // Middlewares
        $this->middleware('sentinel.access:painel.users.read', ['only' => ['index']]);
        $this->middleware('sentinel.access:painel.users.write', ['only' => ['create', 'edit', 'destroy']]);
        // Validator
        $this->validator = $validator;
        // Repositories
        $this->users = Sentinel::getUserRepository();
        $this->roles = Sentinel::getRoleRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all users
        $data = $this->users->orderBy('id', 'desc')->paginate(10);
        // Set breadcrumbs
        Crumbs::addCurrent('Usuários');
        // Return view index
        return view('blog.back.users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Find roles
        $roles = $this->getRoles(Sentinel::Check());
        // Set breadcrumbs
        Crumbs::add(route('painel.users.index'), 'Usuários');
        Crumbs::addCurrent('Adicionar Usuário');
        // Return view create
        return view('blog.back.users.create', compact('data', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Set data
        $data = $request->all();
        // Save or fail
        try {
            // Validate $data
            $this->validator->with($data)->passesOrFail('user_create');
            // Create user
            $user = $this->users->create(array_except($data, 'roles'));
            $user->roles()->sync(array_get($data, 'roles', []));
            // Activate user
            $activation = Activation::create($user);
            Activation::complete($user, $activation->code);
            // Create log
            Activity::log([
                'contentId'   => $user->id,
                'contentType' => 'user',
                'action'      => 'create',
                'description' => 'criou o usuário',
                'details'     => $user->full_name
            ]);
            // Success alert
            flash()->success("Usuário <b>{$user->full_name}</b> criado com sucesso.");
            // Redirect to users index
            return redirect()->route('painel.users.index');
        } catch(ValidatorException $e) {
            // Error alert
            flash()->error('Verifique os erros no formulário.');
            // Redirect to back page with validation errors
            return redirect()->back()->withInput()->withErrors($e->getMessageBag());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find data
        $data = $this->users->findOrFail($id);
        // Find roles
        $roles = $this->getRoles(Sentinel::Check());
        // Get data user roles
        $userRoles = array_keys($data->roles()->pluck('name', 'id')->toArray());
        // Set breadcrumbs
        Crumbs::add(route('painel.users.index'), 'Usuários');
        Crumbs::addCurrent('Editar Usuário');
        // Return view edit
        return view('blog.back.users.edit', compact('data', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Set data
        $data = $request->all();
        // Save or fail
        try {
            // Unset password if not send in data
            if(!$data['password'] && !$data['password_confirmation']):
                unset($data['password']);
                unset($data['password_confirmation']);
            endif;
            // Validate $data
            $this->validator->with($data)->setId($id)->passesOrFail('user_edit');
            // Update user
            $user = $this->users->update($id, array_except($data, 'roles'));
            // Update roles
            if ($id != Sentinel::Check()->id):
                $user->roles()->sync(array_get($data, 'roles', []));
            endif;
            // Create log
            Activity::log([
                'contentId'   => $user->id,
                'contentType' => 'user',
                'action'      => 'update',
                'description' => 'atualizou o usuário',
                'details'     => $user->full_name
            ]);
            // Success alert
            flash()->success("Usuário <b>{$user->full_name}</b> atualizado com sucesso.");
            // Redirect to users index
            return redirect()->route('painel.users.index');
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
        // Find user by id
        if ($user = $this->users->findOrFail($id)):
            // If user != user id logged
            if ($id != Sentinel::Check()->id && !$user->inRole('root')):
                // Delete user
                $user->delete();
                // Create log
                Activity::log([
                    'contentId'   => $user->id,
                    'contentType' => 'user',
                    'action'      => 'delete',
                    'description' => 'excluiu o usuário',
                    'details'     => $user->full_name
                ]);
                // Success alert
                flash()->success("Usuário <b>{$user->full_name}</b> excluído com sucesso.");
            else:
                // Error alert
                flash()->warning('Você não pode excluir este usuário.');
            endif;
        endif;
        // Redirect to users index
        return redirect()->route('painel.users.index');
    }

    /**
     * Get all roles
     * @param  [type] $user Current user
     */
    private function getRoles($user)
    {
      $rolesList = [];
      // Find all roles
      if (Permission::has('painel.users.write')):
          if ($user->inRole('root')):
              // If user in role admin, return all roles
              $roles = $this->roles;
          elseif($user->inRole('admin')):
              // If user in role admin, return roles != root
              $roles = $this->roles->where('slug', '!=', 'root');
          else:
              // Other users, return roles where user roles
              $userRoles = [];
              foreach($user->roles as $role):
                  $userRoles[] = $role->id;
              endforeach;
              $roles = $this->roles->whereIn('id', $userRoles);
          endif;
          $rolesList = $roles->pluck('name', 'id');
      endif;
      return $rolesList;
    }

}
