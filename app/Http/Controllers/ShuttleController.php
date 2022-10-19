<?php

namespace App\Http\Controllers;

use App\Models\MasterArea;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use App\Models\ScheduleShuttle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ShuttleController extends Controller
{
    public function index()
    {
        $shuttlels = ScheduleShuttle::get();

        $data = [];
        foreach ($shuttlels as $key) {
            $id                      = $key->id;
            $from_type               = $key->from_type;
            $from_master_area_id     = $key->from_master_area_id;
            $from_master_sub_area_id = $key->from_master_sub_area_id;
            $to_master_area_id       = $key->to_master_area_id;
            $to_master_sub_area_id   = $key->to_master_sub_area_id;
            $vehicle_name            = $key->vehicle_name;
            $vehicle_number          = $key->vehicle_number;
            $time_departure          = $key->time_departure;
            $is_active               = $key->is_active;
            $photo                   = $key->photo;
            $price                   = $key->price;
            $driver_contact          = $key->driver_contact;
            $notes                   = $key->notes;
            $total_seat              = $key->total_seat;
            $luggage_price           = $key->luggage_price;
            $price                   = $key->price;

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
                'time_departure' => $time_departure,
                'is_active'      => $is_active,
                'photo'          => $photo,
                'price'          => $price,
                'driver_contact' => $driver_contact,
                'notes'          => $notes,
                'total_seat'     => $total_seat,
                'luggage_price'  => $luggage_price,
            ];

            array_push($data, $nested);
        }

        $data = [
            'page_title'     => 'Shuttle',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
            'shuttles'       => $data,
        ];
        return view('admin.shuttle.main')->with($data);
    }

    public function add()
    {
        $data = [
            'page_title'     => 'Add Shuttle',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
        ];
        return view('admin.shuttle.add')->with($data);
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
                'time_departure'          => 'required|date_format:H:i',
                'price'                   => 'required',
                'luggage_price'           => 'required',
                'total_seat'              => 'required',
                'is_active'               => 'required|in:1,0',
                'photo'                   => 'nullable',
                'driver_contact'          => 'nullable',
                'notes'                   => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return redirect('/admin/shuttle/add')
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

        $exec                          = new ScheduleShuttle();
        $exec->from_type               = $request->from_type;
        $exec->from_master_area_id     = $request->from_master_area_id;
        $exec->from_master_sub_area_id = ($request->from_master_sub_area_id) ?? null;
        $exec->to_master_area_id       = $request->to_master_area_id;
        $exec->to_master_sub_area_id   = ($request->to_master_sub_area_id) ?? null;
        $exec->vehicle_name            = $request->vehicle_name;
        $exec->vehicle_number          = $request->vehicle_number;
        $exec->time_departure          = $request->time_departure;
        $exec->is_active               = $request->is_active;
        $exec->photo                   = $filePath;
        $exec->luggage_price           = $request->luggage_price;
        $exec->price                   = $request->price;
        $exec->driver_contact          = $request->driver_contact;
        $exec->notes                   = $request->notes;
        $exec->total_seat              = $request->total_seat;
        $exec->save();
        return redirect()->route('admin.shuttle')->with('success', 'Create successfully.');
    }

    public function edit($id)
    {
        $shuttles = ScheduleShuttle::where('id', $id)->first();
        $data = [
            'page_title'     => 'Edit Shuttle',
            'base_url'       => env('APP_URL'),
            'app_name'       => env('APP_NAME'),
            'app_name_short' => env('APP_NAME_ABBR'),
            'shuttles'       => $shuttles,
        ];
        return view('admin.shuttle.edit')->with($data);
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
                'time_departure'          => 'required|date_format:H:i',
                'price'                   => 'required',
                'luggage_price'           => 'required',
                'total_seat'              => 'required',
                'is_active'               => 'required|in:1,0',
                'photo'                   => 'nullable',
                'driver_contact'          => 'nullable',
                'notes'                   => 'nullable',
            ]
        );

        $photo = $request->file('photo');

        $filePath = ScheduleShuttle::where('id', $id)->first()->photo;
        if ($photo) {
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('img/vehicle/'), $fileName);
            $filePath = 'img/vehicle/' . $fileName;
        }

        $exec                          = ScheduleShuttle::find($id);
        $exec->from_type               = $request->from_type;
        $exec->from_master_area_id     = $request->from_master_area_id;
        $exec->from_master_sub_area_id = ($request->from_master_sub_area_id) ?? null;
        $exec->to_master_area_id       = $request->to_master_area_id;
        $exec->to_master_sub_area_id   = ($request->to_master_sub_area_id) ?? null;
        $exec->vehicle_name            = $request->vehicle_name;
        $exec->vehicle_number          = $request->vehicle_number;
        $exec->time_departure          = $request->time_departure;
        $exec->is_active               = $request->is_active;
        $exec->photo                   = $filePath;
        $exec->price                   = $request->price;
        $exec->driver_contact          = $request->driver_contact;
        $exec->notes                   = $request->notes;
        $exec->total_seat              = $request->total_seat;
        $exec->luggage_price           = $request->luggage_price;
        $exec->save();

        return redirect()->route('admin.shuttle')->with('success', 'Update successfully.');
    }

    public function delete($id)
    {
        ScheduleShuttle::find($id)->delete();
        return response()->json([
            'message' => 'Record deleted successfully!'
        ], 200);
    }
}
