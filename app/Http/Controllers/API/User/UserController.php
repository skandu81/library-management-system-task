<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\User\UserDetailsResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        // Get login user 
        $user = $request->user();

        // Send data using laravel api resource
        return new UserDetailsResource($user);
    }
}
