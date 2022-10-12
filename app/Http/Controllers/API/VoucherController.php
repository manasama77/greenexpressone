<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Models\Voucher;

class VoucherController extends BaseController
{
    public function index()
    {
        //
    }

    public function show(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'voucher_code' => 'required|exists:vouchers,code',
            ],
            [
                'exists' => ':attribute not found',
            ]
        );

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

        $vouchers = Voucher::where('code', $request->voucher_code)->get();

        return $this->sendResponse($vouchers, 'success');
    }
}
