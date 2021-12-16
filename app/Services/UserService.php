<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function store(UserStoreRequest $request): User
    {
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $user->token = $user->createToken('user')->plainTextToken;
        return $user;
    }

    public  function login(LoginRequest $request): ?User
    {
        if (Auth::attempt($request->validated())) {
            $user = $request->user();
            $user->token = $user->createToken('user')->plainTextToken;
            return $user;
        }

        return null;
    }
}
