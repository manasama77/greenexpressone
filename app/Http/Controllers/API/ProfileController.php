<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class ProfileController extends BaseController
{
    public function index()
    {
        return $this->sendResponse(Auth::user(), "success");
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|min:3|max:100',
            'email' => 'nullable|email:rfc,dns',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $photo = $request->file('photo');

        if ($photo) {
            $fileName = Auth::user()->id . '.' . $photo->getClientOriginalExtension();
            $filePath = $photo->storeAs('images/users', $fileName, 'public');
            $filePath = 'storage/' . $filePath;
        }

        $user = Auth::user();
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'photo' => $filePath ?? $user->photo,
        ]);

        $data = [
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'photo' => env('APP_URL') . 'storage/' . $user->photo,
        ];

        return $this->sendResponse($data, "success");
    }
}
