<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'name' => 'required|max:55',
                'email' => 'email|required|unique:users',
                'password' => 'required|confirmed'
            ]);

            if ($validatedData->fails()) {
                return $this->errorResponse($validatedData->errors(), 422);
            }

            $user = User::query()->create($validatedData->getData());
            $token = $user->createToken('authToken')->accessToken;

            return $this->successResponse(['user' => $user, 'token' => $token], 201);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating the user', 500);
        }
    }
}
