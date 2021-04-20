<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListUsersRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\StatusAuthor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::with('roles', 'permissions', 'status')->get();

        return response()->json([
            'data' => $users->toArray(),
            'response_count' => count($users)
        ], 200);
    }

    public function create()
    {
        //
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'slug' => Str::slug($request->first_name.' '.$request->last_name, '-'),
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole(User::ROLE_AUTHOR);
//        $role = new Role();
//        $role->role = "author";
//        $user->role()->save($role);

        $status = new StatusAuthor();
        $status->status = "1";
        $user->status()->save($status);

        return response()->json([
            'data' => $user->toArray()
        ], 201);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
