@extends('layouts.frontend.app')
@section('page_content')
    <section id="home" class="home d-flex align-items-center" data-scroll-index="0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 mt-5">
                    <h1 class="text-center mt-5">Search Airport Shuttle & Charter Booking Schedule</h1>
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="booking section-padding" data-scroll-index="1">
        <img src="img/8493.jpg" class="bg" loading="lazy"/>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-12 mb-5">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="text-center font-weight-bold mb-4">Airport Shuttle & Charter Booking</h5>
                            <form action="{{ route('search') }}" method="get">

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="from_master_sub_area_id"
                                                           class="form-text font-weight-bold">Departure</label>
                                                    <select class="form-control select2" id="from_master_sub_area_id"
                                                            name="from_master_sub_area_id"
                                                            data-placeholder="Sub From/Departure"
                                                            style="width: 100%;"
                                                    >
                                                        <option value=""></option>
                                                        @foreach($master_area as $item)
                                                            <optgroup label="{{$item->name}}">
                                                                @foreach($item->master_sub_area as $subItem)
                                                                    @if($request->from_master_sub_area_id == $subItem->id)
                                                                        <option value="{{ $subItem->id }}"
                                                                                data-area-type="{{ $item->area_type }}"
                                                                                data-master-area-id="{{ $subItem->master_area_id }}"
                                                                                selected>{{$subItem->name}}</option>
                                                                    @else
                                                                        <option value="{{ $subItem->id }}"
                                                                                data-area-type="{{ $item->area_type }}"
                                                                                data-master-area-id="{{ $subItem->master_area_id }}">{{$subItem->name}}</option>
                                                                    @endif

                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="to_master_sub_area_id"
                                                           class="form-text font-weight-bold">Arrival</label>
                                                    <select class="form-control select2" id="to_master_sub_area_id"
                                                            name="to_master_sub_area_id"
                                                            data-placeholder="Sub To/Arrival"
                                                            style="width: 100%;"
                                                    >
                                                        <option value=""></option>
                                                        @foreach($arrival_area as $item)
                                                            <optgroup label="{{$item->name}}">
                                                                @foreach($item->master_sub_area as $subItem)
                                                                    @if($request->to_master_sub_area_id == $subItem->id)
                                                                        <option value="{{ $subItem->id }}"
                                                                                data-area-type="{{ $item->area_type }}"
                                                                                data-master-area-id="{{ $subItem->master_area_id }}"
                                                                                selected>{{$subItem->name}}</option>
                                                                    @else
                                                                        <option value="{{ $subItem->id }}"
                                                                                data-area-type="{{ $item->area_type }}"
                                                                                data-master-area-id="{{ $subItem->master_area_id }}">{{$subItem->name}}</option>
                                                                    @endif

                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="date_departure" class="form-text font-weight-bold">Outward
                                                        journey</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                           id="date_departure" name="date_departure"
                                                           placeholder="Outward Journey"
                                                           value="{{ $request->date_departure }}"
                                                           required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="form-text font-weight-bold">Type</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="booking_type"
                                                               id="shuttle"
                                                               value="shuttle" {{$request->booking_type =='shuttle' ?"checked" : ""}}>
                                                        <label class="form-check-label" for="shuttle">Shuttle</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="booking_type"
                                                               id="charter"
                                                               value="charter" {{$request->booking_type =='charter' ?"checked" : ""}}>
                                                        <label class="form-check-label"
                                                               for="charter">Charter</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-6 passenger_adult_input" {{$request->booking_type =='charter' ? 'style="display:none;"' : ""}}>
                                                <div class="form-group">
                                                    <label for="passanger_adult" class="form-text font-weight-bold">Adult
                                                        Passangers</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="passanger_adult"
                                                               name="passanger_adult" placeholder="Adult Passangers"
                                                               min="1"
                                                               max="9" value="{{$request->passanger_adult}}" required/>
                                                        <div class="input-group-append bg-light">
                                                            <span class="input-group-text">Adult</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="col-sm-6 passenger_baby_input" {{$request->booking_type =='charter' ? 'style="display:none;"' : ""}}>
                                                <div class="form-group">
                                                    <label for="passanger_baby" class="form-text font-weight-bold">Child
                                                        Passangers</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="passanger_baby"
                                                               name="passanger_baby" placeholder="Adult Passangers"
                                                               min="0"
                                                               aria-describedby="inputGroup-sizing-sm"
                                                               max="9" value="{{$request->passanger_baby}}" required/>
                                                        <div class="input-group-append bg-light"
                                                             id="inputGroup-sizing-sm">
                                                            <span class="input-group-text text-sm">Child</span>
                                                        </div>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Child is under 8 years old
                                                    </small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search fa-fw"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="card card-semi shadow">
                        <div class="card-body">
                            <div class="section-title">
                                <h1>Schedue List</h1>
                                <div class="row" id="list_jadwal">
                                    @forelse($schedule as $item)
                                        <div class="col-12 my-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-md-5">
                                                            <div class="row">
                                                                <div class="col-sm-7 d-flex align-items-center justify-content-center flex-column">
                                                                    <h5
                                                                        style="font-size: 1rem; font-weight: 700;">From
                                                                        {{$item->from_master_area->name}}
                                                                        {{$item->from_master_sub_area->name}} <br>
                                                                        <br>
                                                                        To {{$item->to_master_area->name}} {{$item->to_master_sub_area->name}}</h5>
                                                                </div>
                                                                <div
                                                                    class="col-sm-5 text-right d-flex align-items-center justify-content-end">
                                                                    <div>
                                                                        <span
                                                                            class="font-weight-bold">Time Departure : </span><br>
                                                                        <h3 class="font-weight-bold text-danger">{{substr($item->time_departure,0,5)}}</h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-5 d-flex align-items-center">
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-6 d-flex align-items-center">
                                                                    <div>
                                                                        <p> Vehicle data :<br>
                                                                            <span class="font-weight-bold">{{$item->vehicle_name}}
                                                                            -
                                                                            {{$item->vehicle_number}}</span> <br>
                                                                            Available Seat : <br>
                                                                            <span class="font-weight-bold"> {{($item->total_seat -$item->seat_booked) > 0 ? $item->total_seat -$item->seat_booked : 0}}</span>

                                                                        </p>
                                                                    </div>

                                                                </div>
                                                                <div class="col-sm-12 col-md-6 d-flex align-items-center">
                                                                    <div>
                                                                        <p> Prices : <br>
                                                                            Luggage Price :
                                                                            <span class="font-weight-bold text-primary">${{$item->luggage_price}}</span> <br>
                                                                            Rent Price : <br>
                                                                            <span class="font-weight-bold text-primary">${{$item->price}}</span>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12 col-md-1 my-auto">
                                                            <form method="post" action="/booking">
                                                                @csrf
                                                                <input type="hidden" name="from_type"
                                                                       value="{{$item->from_type}}"/>
                                                                <input type="hidden" name="from_master_area_id"
                                                                       value="{{$item->from_master_area_id}}"/>
                                                                <input type="hidden"
                                                                       name="from_master_sub_area_id"
                                                                       value="{{ $request->from_master_sub_area_id}}"/>
                                                                <input type="hidden" name="to_master_area_id"
                                                                       value="{{ $item->to_master_area_id}}"/>
                                                                <input type="hidden"
                                                                       name="to_master_sub_area_id"
                                                                       value="{{ $request->to_master_sub_area_id}}"/>
                                                                <input type="hidden" name="booking_type"
                                                                       value="{{ $request->booking_type}}"/>
                                                                <input type="hidden" name="date_departure"
                                                                       value="{{ $request->date_departure}}"/>
                                                                <input type="hidden" name="passanger_adult"
                                                                       value="{{ $request->passanger_adult}}"/>
                                                                <input type="hidden" name="passanger_baby"
                                                                       value="{{ $request->passanger_baby}}"/>
                                                                <input type="hidden" name="special_area_id"
                                                                       value="{{ $item->special_area_id}}"/>
                                                                <input type="hidden" name="schedule_id"
                                                                       value="{{ $item->id}}"/>
                                                                <button type="submit"
                                                                        class="btn btn-info font-weight-bold sm:btn-block {{ $item->is_available ? "" : "disabled"}}">
                                                                    <i class="fas fa-shuttle-van"></i> Choose
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                        <div class="col-12 text-center">
                                            <img src="/img/undraw_empty_re_opql.svg" alt="not found"
                                                 style="width: 400px;"/>
                                        </div>
                                        <div class="col-12 text-center text-danger">
                                            <h5 class="my-3 font-weight-bold">Schedule Not Found</h5>
                                        </div>
                                    @endforelse

                                    <div class="col-sm-12 mt-2 d-flex justify-content-center">
                                       <div> {{ $schedule->links() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vitamin')
    <script src="/js/booking.js"></script>
@endsection
