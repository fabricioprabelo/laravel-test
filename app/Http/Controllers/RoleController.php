<?php

namespace App\Http\Controllers;

use App\Enums\PermissionEnum;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:' . PermissionEnum::ROLE_LIST->value)
            ->only(['index']);
        $this->middleware('role_or_permission:' . PermissionEnum::ROLE_CREATE->value)
            ->only(['create', 'store']);
        $this->middleware('role_or_permission:' . PermissionEnum::ROLE_UPDATE->value)
            ->only(['show', 'edit', 'update']);
        $this->middleware('role_or_permission:' . PermissionEnum::ROLE_DELETE->value)
            ->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('guard_name', 'web')
            ->paginate();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $permissions = Permission::where('guard_name', 'web')->get();
        return view('roles.create', compact('permissions', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();

            $post = $request->only([
                'name',
            ]);

            $role = Role::create(array_merge($post, ['guard_name' => 'web']));
            $roleApi = Role::create(array_merge($post, ['guard_name' => 'api']));

            if ($request->only('users')) {
                $users = $request->only('users')['users'];
                DB::table(config('permission.table_names.model_has_roles'))
                    ->where('role_id', $role->id)
                    ->delete();
                foreach($users as $user_id) {
                    $user = User::where('id', $user_id)->firstOrFail();
                    DB::table(config('permission.table_names.model_has_roles'))
                        ->insert([
                            'role_id' => $role->id,
                            'model_type' => get_class($user),
                            'model_id' => $user_id,
                        ]);
                }
            }

            if ($request->only('permissions')) {
                $permissions = $request->only('permissions')['permissions'];
                $role->syncPermissions($permissions);
                $roleApi->syncPermissions($permissions);
            }

            DB::commit();

            return redirect()->route('roles.edit', $role);

        } catch (Exception $e) {

            DB::rollBack();

            return back()
                ->withInput($request->all())
                ->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $users = User::all();
        $permissions = Permission::where('guard_name', 'web')->get();
        $role->selected_users = $role->selectedUsers();
        $role->selected_permissions = $role->selectedPermissions();
        return view('roles.edit', compact('role', 'users', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $users = User::all();
        $permissions = Permission::where('guard_name', 'web')->get();
        $role->selected_users = $role->selectedUsers();
        $role->selected_permissions = $role->selectedPermissions();
        return view('roles.edit', compact('role', 'users', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            $post = $request->only([
                'name',
            ]);

            $roleApi = Role::where('name', $role->name)->firstOrFail();

            $role->update($post);
            $roleApi->update($post);

            if ($request->only('users')) {
                $users = $request->only('users')['users'];
                DB::table(config('permission.table_names.model_has_roles'))
                    ->where('role_id', $role->id)
                    ->delete();
                foreach($users as $user_id) {
                    $user = User::where('id', $user_id)->firstOrFail();
                    DB::table(config('permission.table_names.model_has_roles'))
                        ->insert([
                            'role_id' => $role->id,
                            'model_type' => get_class($user),
                            'model_id' => $user_id,
                        ]);
                }
            }

            if ($request->only('permissions')) {
                $permissions = $request->only('permissions')['permissions'];
                $role->syncPermissions($permissions);
                $roleApi->syncPermissions($permissions);
            }

            DB::commit();

            return back();

        } catch (Exception $e) {

            DB::rollBack();

            return back()
                ->withInput($request->all())
                ->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {

            DB::beginTransaction();

            $role->delete();

            DB::table(config('permission.table_names.role_has_permissions'))
                        ->where('role_id', $role->id)
                        ->delete();

            DB::table(config('permission.table_names.model_has_roles'))
                        ->where('role_id', $role->id)
                        ->delete();

            DB::commit();

            return redirect()->route('roles.index');

        } catch (Exception $e) {

            DB::rollBack();

            return back()
                ->withErrors($e->getMessage());
        }
    }
}
