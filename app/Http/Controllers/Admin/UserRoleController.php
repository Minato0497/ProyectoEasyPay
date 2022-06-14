<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        // $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.user.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'id' => 'required',
            // 'name' => "required|unique:users,name,$request->id",
            'email' => "required",
            'roles' => 'present',
            'permissions' => 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 400, 'validation_error' => $validator->errors()->toArray()]);
        } else {
            $data = $validator->validated();
            try {
                DB::beginTransaction();

                $user = User::findOrFail($data['id']);
                $user->roles()->sync(request()->roles);
                $user->permissions()->sync(request()->permissions);
                // $cancel_store_trait = in_array(CancelStoring::class, class_uses(new User));
                //El trait deshabilita la edición
                if (!$user) {
                    DB::rollback();
                    return response()->json(['cancel_store_trait_error' => 'This external module has disabled any changes']);
                } else {
                    DB::commit();
                    return response()->json(['submit_store_success' => 'User role updated successfully']);
                }
            } catch (\Exception $myException) {
                DB::rollBack();
                // throw new StoreErrorException('store', 'admin-security-user-roles-store', json_encode($data), $myException);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if (request()->ajax()) {
            return response()->json([
                'user' => $user,
                'roles' => $user->roles,
                'permissions' => $user->permissions
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->roles()->sync($request->roles);
        return redirect()->route('roleUser.edit', $user)->with('info', 'Se asignaron los roles correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function getUserDatatable()
    {
        $models = User::all();
        // if (request()->ajax()) {
        return DataTables::of($models)
            ->addIndexColumn()
            ->addColumn('Actions', function ($data) {
                $btn = '';
                $btn = '<a href="javascript:void(0)" data-modelid="' . $data->id . '" class="edit btn btn-primary btn-sm edit"><i class="fas fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('roles', function ($model) {
                $roles = [];
                $view = '';
                if ($model->roles) {
                    foreach ($model->roles->pluck('name') as $role) {
                        $roles[] = $role;
                    }
                    $view = implode(", ", $roles);
                } else {
                    $view = '';
                }
                return $view;
            })
            ->addColumn('directPermisions', function ($data) {
                $permissions = [];
                if ($data->name == 'SuperAdmin') {
                    $permissions = 'Todo';
                } else {
                    foreach ($data->getDirectPermissions() as $permission) {
                        $permissions[] = $permission->name;
                    }
                    $permissions = implode(', ', $permissions);
                }
                return $permissions;
            })
            ->addColumn('allPermisions', function ($data) {
                $permissions = [];
                if ($data->name == 'SuperAdmin') {
                    $permissions = 'Todo';
                } else {
                    foreach ($data->getAllPermissions() as $permission) {
                        $permissions[] = $permission->name;
                    }
                    $permissions = implode(', ', $permissions);
                }
                return $permissions;
            })
            ->rawColumns(['Actions', 'details'])
            ->make(true);
    }
}
