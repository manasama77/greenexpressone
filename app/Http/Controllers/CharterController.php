<?php

namespace App\Http\Controllers;

use App\Models\Charter;
use App\Models\MasterArea;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CharterController extends Controller
{
    public function index()
    {
        $charters = Charter::get();

        $data = [];
        foreach ($charters as $key) {
            $id                      = $key->id;
            $from_type               = $key->from_type;
            $from_master_area_id     = $key->from_master_area_id;
            $from_master_sub_area_id = $key->from_master_sub_area_id;
            $to_master_area_id       = $key->to_master_area_id;
            $to_master_sub_area_id   = $key->to_master_sub_area_id;
            $vehicle_name            = $key->vehicle_name;
            $vehicle_number          = $key->vehicle_number;
            $is_available            = $key->is_available;
            $photo                   = $key->photo;
            $price                   = $key->price;
            $driver_contact          = $key->driver_contact;
            $notes                   = $key->notes;

            $from_master_area_name     = MasterArea::where('id', $from_master_area_id)->first()->name;
            $from_master_sub_area_name = null;
            if ($from_master_sub_area_id) {
                $from_master_sub_area_name = MasterSubArea::where('id', $from_master_sub_area_id)->first()->name;
            }
            $from_area = ($from_master_sub_area_id) ? $from_master_area_name . " - " . $from_master_sub_area_name : $from_master_area_name;

            $to_master_area_name     = MasterArea::where('id', $to_master_area_id)->first()->name;
            $to_master_sub_area_name = null;
            if ($to_master_sub_area_id) {
                $to_master_sub_area_name = MasterSubArea::where('id', $to_master_sub_area_id)->first()->name;
            }
            $to_area = ($to_master_sub_area_id) ? $to_master_area_name . " - " . $to_master_sub_area_name : $to_master_area_name;

            $nested = [
                'id'             => $id,
                'from_type'      => $from_type,
                'from_area'      => $from_area,
                'to_area'        => $to_area,
                'vehicle_name'   => $vehicle_name,
                'vehicle_number' => $vehicle_number,
                'is_available'   => $is_available,
                'photo'          => $photo,
                'price'          => $price,
                'driver_contact' => $driver_contact,
                'notes'          => $notes,
            ];

            array_push($data, $nested);
        }

        $data = [
            'page_title'     => 'Charter',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
            'charters'       => $data,
        ];
        return view('admin.charter.main')->with($data);
    }

    public function add()
    {
        $data = [
            'page_title'     => 'Add Charter',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
        ];
        return view('admin.charter.add')->with($data);
    }

    public function store(Request $request)
    {
        $validator  = Validator::make(
            $request->all(),
            [
                'from_type'               => 'required',
                'from_master_area_id'     => 'required',
                'from_master_sub_area_id' => 'exclude_if:from_type,airport|required',
                'to_master_area_id'       => 'required',
                'to_master_sub_area_id'   => 'exclude_if:from_type,city|required',
                'vehicle_name'            => 'required',
                'vehicle_number'          => 'required',
                'is_available'            => 'required|in:1,0',
                'photo'                   => 'nullable',
                'price'                   => 'required',
                'driver_contact'          => 'nullable',
                'notes'                   => 'nullable',
            ],
        );

        if ($validator->fails()) {
            return redirect('/admin/charter/add')
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        $photo = $request->file('photo');
        $filePath = 'img/vehicle/default.png';
        if ($photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('img/vehicle/'), $fileName);
            $filePath = 'img/vehicle/' . $fileName;
        }

        $exec                          = new Charter();
        $exec->from_type               = $request->from_type;
        $exec->from_master_area_id     = $request->from_master_area_id;
        $exec->from_master_sub_area_id = ($request->from_master_sub_area_id) ?? null;
        $exec->to_master_area_id       = $request->to_master_area_id;
        $exec->to_master_sub_area_id   = ($request->to_master_sub_area_id) ?? null;
        $exec->vehicle_name            = $request->vehicle_name;
        $exec->vehicle_number          = $request->vehicle_number;
        $exec->is_available            = $request->is_available;
        $exec->photo                   = $filePath;
        $exec->price                   = $request->price;
        $exec->driver_contact          = $request->driver_contact;
        $exec->notes                   = $request->notes;
        $exec->save();
        return redirect()->route('admin.charter')->with('success', 'Create successfully.');
    }

    public function edit($id)
    {
        $charters = Charter::where('id', $id)->first();
        $data = [
            'page_title'     => 'Edit Charter',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
            'charters'       => $charters,
        ];
        return view('admin.charter.edit')->with($data);
    }

    public function update($id, Request $request)
    {
        $request->validate(
            [
                'from_type'               => 'required',
                'from_master_area_id'     => 'required',
                'from_master_sub_area_id' => 'exclude_if:from_type,airport|required',
                'to_master_area_id'       => 'required',
                'to_master_sub_area_id'   => 'exclude_if:from_type,city|required',
                'vehicle_name'            => 'required',
                'vehicle_number'          => 'required',
                'is_available'            => 'required|in:1,0',
                'photo'                   => 'nullable',
                'price'                   => 'required',
                'driver_contact'          => 'nullable',
                'notes'                   => 'nullable',
            ]
        );

        $photo = $request->file('photo');

        $filePath = Charter::where('id', $id)->first()->photo;
        if ($photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('img/vehicle/'), $fileName);
            $filePath = 'img/vehicle/' . $fileName;
        }

        $exec                          = Charter::find($id);
        $exec->from_type               = $request->from_type;
        $exec->from_master_area_id     = $request->from_master_area_id;
        $exec->from_master_sub_area_id = ($request->from_master_sub_area_id) ?? null;
        $exec->to_master_area_id       = $request->to_master_area_id;
        $exec->to_master_sub_area_id   = ($request->to_master_sub_area_id) ?? null;
        $exec->vehicle_name            = $request->vehicle_name;
        $exec->vehicle_number          = $request->vehicle_number;
        $exec->is_available            = $request->is_available;
        $exec->photo                   = $filePath;
        $exec->price                   = $request->price;
        $exec->driver_contact          = $request->driver_contact;
        $exec->notes                   = $request->notes;
        $exec->save();

        return redirect()->route('admin.charter')->with('success', 'Update successfully.');
    }

    public function delete($id)
    {
        Charter::find($id)->delete();
        return response()->json([
            'message' => 'Record deleted successfully!'
        ], 200);
    }
}
