<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponser;

    public function updateMe(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $user = auth()->user();
            if ($request->has('name')){
                $user->name = $request->name;
            }
            if ($request->has('email')){
                $user->email = $request->email;
            }
            if ($request->has('address')){
                $user->address = $request->address;
            }
            if ($request->has('birthdate')){
                $user->birthdate = $request->birthdate;
            }
            if ($request->has('city')){
                $user->city = $request->city;
            }
            if($user->isClean()){
                return $this->errorResponse('At least one value must change', 422);
            }
            $user->save();
            return $this->successResponse($user);
        } catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function me(): \Illuminate\Http\JsonResponse
    {
        try{
            $user = auth()->user();
            return $this->successResponse($user);
        } catch (\Exception $e){
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
