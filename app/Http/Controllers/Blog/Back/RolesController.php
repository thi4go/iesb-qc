<?php

namespace App\Http\Controllers\Blog\Back;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Validators\RoleValidator;
use App\Models\Permission;
use Prettus\Validator\Exceptions\ValidatorException;
use Crumbs;
use Sentinel;
use Activity;

class RolesController extends PainelController
{

    /**
     * @var [type]
     */
    protected $validator;

    /**
     * @var [type]
     */
    protected $role;

    /**
     * @var object
     */
    protected $permission;

    /**
     * Construct
     */
    public function __construct(RoleValidator $validator, Permission $permission)
    {
        // Middlewares
        $this->middleware('sentinel.access:painel.roles.read', ['only' => ['index']]);
        $this->middleware('sentinel.access:painel.roles.write', ['only' => ['create', 'edit', 'destroy']]);
        // Validator
        $this->validator = $validator;
        // Entities
        $this->role = Sentinel::getRoleRepository();
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Sentinel::getUser();
        // Get roles
        if ($user->inRole('root')):
            // If user in role admin, return all roles
            $roles = $this->role;
        elseif($user->inRole('admin')):
            // If user in role admin, return roles != root
            $roles = $this->role->where('slug', '!=', 'root');
        else:
            // Other users, return roles where user roles
            $userRoles = [];
            foreach($user->roles as $role):
                $userRoles[] = $role->id;
            endforeach;
            $roles = $this->role->whereIn('id', $userRoles);
        endif;
        $data = $roles->orderBy('id', 'desc')->paginate(10);
        // Set breadcrumbs
        Crumbs::addCurrent('Grupos');
        // Return view index
        return view('blog.back.roles.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all permissions
        $permissions = $this->permission->pluck('name', 'slug');
        // Set breadcrumbs
        Crumbs::add(route('painel.roles.index'), 'Grupos');
        Crumbs::addCurrent('Adicionar Grupo');
        // Return view create
        return view('blog.back.roles.create', compact('permissions'));
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
            $this->validator->with(array_except($data, 'permissions'))->passesOrFail();
            // Validate permissions
            if (!is_array(array_get($data, 'permissions'))):
                // Error alert
                flash()->error('Defina as permissões para este grupo.');
                // Redirect to back page
                return redirect()->back()->withInput();
            endif;
            // Create role
            $role = $this->role->create(array_except($data, 'roles'));
            // Cast permissions values to boolean
            $permissions = [];
            foreach (array_get($data, 'permissions') as $permission => $value):
                $permissions[$permission] = (bool)$value;
            endforeach;
            // Set the role permissions
            $role->permissions = $permissions;
            $role->save();
            // Create log
            Activity::log([
                'contentId'   => $role->id,
                'contentType' => 'role',
                'action'      => 'create',
                'description' => 'criou o grupo',
                'details'     => $role->name
            ]);
            // Success alert
            flash()->success("Grupo <b>{$role->name}</b> criado com sucesso.");
            // Redirect to roles index
            return redirect()->route('painel.roles.index');
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
        $data = $this->role->find($id);
        // Get all permissions
        $permissions = $this->permission->pluck('name', 'slug');
        // Set breadcrumbs
        Crumbs::add(route('painel.roles.index'), 'Grupos');
        Crumbs::addCurrent('Editar Grupo');
        // Return view edit
        return view('blog.back.roles.edit', compact('data', 'permissions'));
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
            $this->validator->with(array_except($data, 'permissions'))->setId($id)->passesOrFail();
            // Validate permissions
            if (!is_array(array_get($data, 'permissions'))):
                // Error alert
                flash()->error('Defina as permissões para este grupo.');
                // Redirect to back page
                return redirect()->back()->withInput();
            endif;
            // Find role by id
            $role = $this->role->find($id);
            // Cast permissions values to boolean
            $permissions = [];
            foreach (array_get($data, 'permissions') as $permission => $value):
                $permissions[$permission] = (bool)$value;
            endforeach;
            // Set name and permissions
            $role->name = array_get($data, 'name');
            $role->permissions = $permissions;
            // Update role
            $role->save();
            // Create log
            Activity::log([
                'contentId'   => $role->id,
                'contentType' => 'role',
                'action'      => 'update',
                'description' => 'atualizou o grupo',
                'details'     => $role->name
            ]);
            // Success alert
            flash()->success("Grupo <b>{$role->name}</b> atualizado com sucesso.");
            // Redirect to roles index
            return redirect()->route('painel.roles.index');
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
        // Find role by id
        if ($role = $this->role->find($id)):
            // Delete role
            $role->delete();
            // Create log
            Activity::log([
                'contentId'   => $role->id,
                'contentType' => 'role',
                'action'      => 'delete',
                'description' => 'excluiu o grupo',
                'details'     => $role->name
            ]);
            // Success alert
            flash()->success("Grupo <b>{$role->name}</b> excluído com sucesso.");
        endif;
        // Redirect to roles index
        return redirect()->route('painel.roles.index');
    }

}
