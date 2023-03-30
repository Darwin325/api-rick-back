<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class FavoriteController extends Controller
{
    use ApiResponser;

    public function index()
    {
        return $this->successResponse(['data' => Favorite::all()]);
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->validate($request, [
            'ref_api' => 'required|string'
        ]);

        try{
            $user = Auth::user()->id ?? 5;
            $request->merge(['user_id' => $user]);

            $favorite = Favorite::query()->create($request->all());
            return $this->successResponse(['data' => $favorite], 201);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while creating the favorite', 500);
        }
    }

    public function destroy(Favorite $favorite): \Illuminate\Http\JsonResponse
    {
        try {
            $favorite->delete();
            return $this->successResponse(['data' => $favorite], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting the favorite', 500);
        }
    }

    public function getFavoritesByUser()
    {
        try {
            $favorites = Favorite::query()->where('user_id', auth()->user()->id)->get();
            return $this->successResponse(['data' => $favorites], 200);
        } catch (\Exception $e) {
            return $this->errorResponse('An error occurred while deleting the favorite', 500);
        }
    }
}
