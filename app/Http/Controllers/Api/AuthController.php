<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\API\BaseController as BaseController;

class AuthController extends BaseController
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'phone'    => 'required|unique:users',
            'password' => 'required|min:8',
            'email'    => 'required|email:rfc,dns',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $token =  $user->createToken($user->phone)->plainTextToken;

        $result = [
            'name'  => $user->name,
            'phone' => $user->phone,
            'photo' => $user->photo,
            'email' => $user->email,
            'token' => $token,
        ];

        return $this->sendResponse($result, 'User register successfully.');
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'phone'    => 'required|exists:users,phone',
                'password' => 'required|min:8',
            ],
            [
                'phone' => [
                    'exists' => 'Phone not found'
                ],
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $user = User::where('phone', $request->phone)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Unauthorized', null, 401);
        }

        $token = $user->createToken($user->phone)->plainTextToken;

        $result = [
            'id'    => $user->id,
            'name'  => $user->name,
            'phone' => $user->phone,
            'photo' => $user->photo,
            'email' => $user->email,
            'token' => $token,
        ];

        return $this->sendResponse($result, 'success');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse(null, 'logout success');
    }
}
