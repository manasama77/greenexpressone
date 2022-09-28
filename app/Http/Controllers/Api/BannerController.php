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

        $arr_banner = Banner::where('is_active', 'yes')->get();

        if ($arr_banner->count() > 0) {
            foreach ($arr_banner->result() as $key) {
                $picture = $key->picture;
                $url = $key->url;
                $nested = [
                    'picture' => $picture,
                    'url'     => $url,
                ];
                array_push($result, $nested);
            }
        } else {
            return $this->sendError('Data empty', $result, 404);
        }

        return $this->sendResponse($result, 'success');
    }
}
