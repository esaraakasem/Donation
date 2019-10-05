<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponses;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use App\Models\User;

class AuthController extends Controller
{
	use ApiResponses;
	
    
    public function userLogin()
    {
        $validation = $this->apiValidation(request(), ['fcm_android' => 'required']);
        if ($validation instanceof Response) { return $validation; }

        $credentials = request(['email', 'password']);
        $credentials['role'] = 'user';

        if (! $token = auth()->attempt($credentials)) {
            return $this->apiResponse(null,'These credentials do not match our records.', 401);
        }
        auth()->user()->update(['fcm_android' => request('fcm_android')]);
        return $this->respondWithToken($token);
    }

    public function adminLogin()
    {
        $validation = $this->apiValidation(request(), ['fcm_android' => 'required']);
        if ($validation instanceof Response) { return $validation; }

        $credentials = request(['email', 'password']);
        $credentials['role'] = 'admin';
        
        if (! $token = auth()->attempt($credentials)) {
            return $this->apiResponse(null,'These credentials do not match our records.', 401);
        }

        auth()->user()->update(['fcm_android' => request('fcm_android')]);

        return $this->respondWithToken($token);
    }

    public function register()
    {
    	$rules = [
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required'
    	];

    	$validation = $this->apiValidation(request(), $rules);
    	if ($validation instanceof Response) { return $validation; }

    	$data = request()->all();
    	$data['password'] = bcrypt($data['password']);
    	$user = new User($data);
    	$user->save();

    	$token = auth()->login($user);
    	return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth()->user()->update(['fcm_android' => null]);
        auth()->logout();

        return $this->apiResponse('Logout success');
    }

    protected function respondWithToken($token)
    {
    	$user = auth()->user();
    	$user['token'] = $token;
        return $this->apiResponse(new UserResource($user));
    }

}
