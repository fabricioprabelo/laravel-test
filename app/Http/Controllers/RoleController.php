<?php

namespace App\Http\Controllers;

use App\Enums\PermissionEnum;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
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
        $roles = Role::with(['permissions'])->paginate();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            DB::beginTransaction();

            $role = Role::create($request->only([
                'name',
                'address',
                'complement',
                'neighborhood',
                'city',
                'state',
                'zip_code',
                'website'
            ]));

            if ($request->only('roles')) {
                $roles = $request->only('roles')['roles'];
                foreach($roles as $role) {
                    $role->roles()->create([
                        'name' => $role['name'],
                        'description' => $role['description'],
                    ]);
                }
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
        $role->with(['roles']);
        return view('roles.edit', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role->with(['roles']);
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            DB::beginTransaction();

            $role->update($request->only([
                    'name',
                    'address',
                    'complement',
                    'neighborhood',
                    'city',
                    'state',
                    'zip_code',
                    'website',
                ]));

            if ($request->only('roles')) {
                $roles = $request->only('roles')['roles'];
                foreach($roles as $role) {
                    $role->roles()->create([
                        'name' => $role['name'],
                        'description' => $role['description'],
                    ]);
                }
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
        $role->delete();

        return redirect()->route('roles.index');
    }
}
