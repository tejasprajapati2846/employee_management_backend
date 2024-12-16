<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\API\BaseController as BaseController;

class RegisterController extends BaseController
{
    /**
     * Register Employee
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('employee-token')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'Employee register successfully.');
    }

    /**
     * Login Employee
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        $params = $request->only('email', 'password');
        if (Auth::attempt($params, false, false)) {
            $user = auth()->user();
            $success['token'] =  $user->createToken('user-token')->accessToken;
            $success['name'] =  $user->name;
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised'],401);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return $this->sendResponse([
                'success' => true,
                'message' => 'Logged out successfully',
            ], 200);
        }
    }   
}