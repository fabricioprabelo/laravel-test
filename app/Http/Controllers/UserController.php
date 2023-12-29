<?php

namespace App\Http\Controllers;

use App\Enums\PermissionEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:' . PermissionEnum::USER_LIST->value)
            ->only(['index']);
        $this->middleware('role_or_permission:' . PermissionEnum::USER_CREATE->value)
            ->only(['create', 'store']);
        $this->middleware('role_or_permission:' . PermissionEnum::USER_UPDATE->value)
            ->only(['show', 'edit', 'update']);
        $this->middleware('role_or_permission:' . PermissionEnum::USER_DELETE->value)
            ->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['roles'])->paginate();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('guard_name', 'web')->get();
        $permissions = Permission::where('guard_name', 'web')->get();
        return view('users.create', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $post = $request->only([
                'name',
                'email',
                'password'
            ]);


            $post['password'] = Hash::make(trim($post['password']));

            $user = User::create($post);

            if ($request->only('roles')) {
                $roles = $request->only('roles')['roles'];
                $user->syncRoles($roles);
            }

            if ($request->only('permissions')) {
                $permissions = $request->only('permissions')['permissions'];
                $user->syncPermissions($permissions);
            }

            DB::commit();

            return redirect()->route('users.edit', $user);

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
    public function show(User $user)
    {
        $roles = Role::where('guard_name', 'web')->get();
        $permissions = Permission::where('guard_name', 'web')->get();
        $user->selected_roles = $user->selectedRoles();
        $user->selected_permissions = $user->selectedPermissions();
        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::where('guard_name', 'web')->get();
        $permissions = Permission::where('guard_name', 'web')->get();
        $user->selected_roles = $user->selectedRoles();
        $user->selected_permissions = $user->selectedPermissions();
        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $post = $request->only([
                'name',
                'email',
                'password'
            ]);

            if (trim($post['password'])) {
                $post['password'] = Hash::make(trim($post['password']));
            } else {
                unset($post['password']);
            }

            $user->update($post);

            if ($request->only('roles')) {
                $roles = $request->only('roles')['roles'];
                $user->syncRoles($roles);
            }

            if ($request->only('permissions')) {
                $permissions = $request->only('permissions')['permissions'];
                $user->syncPermissions($permissions);
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
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
