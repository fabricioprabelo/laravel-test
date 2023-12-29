<?php

namespace App\Http\Controllers;

use App\Enums\PermissionEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

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
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = User::create($request->only([
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
                    $user->roles()->create([
                        'name' => $role['name'],
                        'description' => $role['description'],
                    ]);
                }
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
        $user->with(['roles']);
        return view('users.edit', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->with(['roles']);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $user->update($request->only([
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
                    $user->roles()->create([
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
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
