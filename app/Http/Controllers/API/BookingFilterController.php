<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MasterArea;
use Illuminate\Http\Request;

class BookingFilterController extends BaseController
{
    public function get_arrival_filter(Request $request)
    {
        $data = MasterArea::when($request->area_type, function ($q, $area_type) use ($request) {
            $area_type = $request->area_type == 'airport' ? 'city' : 'airport';
            $q->where('area_type', $area_type);
        })->with(['master_sub_area' => function ($q) {
            $q->where('is_active', '1');
        }])->where('is_active', '1')->get();

        $arr = [];

        foreach ($data as $idx => $item) {
            $arr[$idx]['text'] = $item->name;
            foreach ($item->master_sub_area as $subItem) {
                $arr[$idx]['children'][] = [
                    'id' => $subItem->id,
                    'name' => $subItem->name,
                    'master_area_id' => $subItem->master_area_id,
                    'area_type' => $item->area_type,
                ];
            }
        }

        return $this->sendResponse($arr, 'Data founded');
    }
}
