<?php

namespace App\Http\Controllers\API;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\BaseController;

class BannerController extends BaseController
{
    public function index()
    {
        $result = [];

        $arr_banner = Banner::where('is_active', true)->get();

        if ($arr_banner->count() == 0) {
            return $this->sendError('Data empty', $result);
        }

        return $this->sendResponse($arr_banner, 'success');
    }
}
