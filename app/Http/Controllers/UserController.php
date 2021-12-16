<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Traits\ResponserTrait;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    use ResponserTrait;

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        return $this->respondCollection('Success', $this->userService->store($request));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = $this->userService->login($request);
        if ($user) {
            return $this->respondCollection('Success', $user);
        }
        return $this->respondUnautorized();
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->respondSuccessMsgOnly('Success');
    }
}
