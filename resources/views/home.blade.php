@extends('layouts.frontend.app')
@section('gaya')
<!--    <style>-->
<!--        .slick-slide {-->
<!--            height: 500px;-->
<!--        }-->
<!---->
<!--        .slick-slide img {-->
<!--            height: 100%;-->
<!--        }-->
<!--    </style>-->
@endsection
@section('page_content')
    <section id="home" class="home d-flex align-items-center" data-scroll-index="0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    @include('Components.Banner')
                    {{-- <x-banner :banners=$banners></x-banner> --}}
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="booking section-padding" data-scroll-index="1">
<!--        <img src="img/8493.jpg" class="bg" loading="lazy" />-->
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
                                                        class="form-text font-weight-bold">From</label>
                                                    <select class="form-control select2" id="from_master_sub_area_id"
                                                        name="from_master_sub_area_id"
                                                        data-placeholder="Select from location" style="width: 100%;"
                                                        required>
                                                        <option value=""></option>
                                                        @foreach ($master_area as $item)
                                                            <optgroup label="{{ $item->name }}">
                                                                @foreach ($item->master_sub_area as $subItem)
                                                                    <option value="{{ $subItem->id }}"
                                                                        data-area-type="{{ $item->area_type }}"
                                                                        data-master-area-id="{{ $subItem->master_area_id }}">
                                                                        {{ $subItem->name }}</option>
                                                                @endforeach
                                                            </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="to_master_sub_area_id"
                                                        class="form-text font-weight-bold">To</label>
                                                    <select class="form-control select2" id="to_master_sub_area_id"
                                                        name="to_master_sub_area_id" data-placeholder="Select to location"
                                                        disabled style="width: 100%;" required>
                                                        <option value=""></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="date_departure" class="form-text font-weight-bold">Departure
                                                        date</label>
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="date_departure" name="date_departure"
                                                        placeholder="Departure date"
                                                        value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required />
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="form-text font-weight-bold">Type</label>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="booking_type"
                                                            id="shuttle" value="shuttle" checked>
                                                        <label class="form-check-label" for="shuttle">Shuttle</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="booking_type"
                                                            id="charter" value="charter">
                                                        <label class="form-check-label" for="charter">Charter</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 passenger_adult_input">
                                                <div class="form-group">
                                                    <label for="passanger_adult" class="form-text font-weight-bold">Adult
                                                        Passangers</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="passanger_adult"
                                                            name="passanger_adult" placeholder="Adult Passangers"
                                                            min="1" max="9" value="1" required />
                                                        <div class="input-group-append bg-light">
                                                            <span class="input-group-text">Adult</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 passenger_baby_input">
                                                <div class="form-group">
                                                    <label for="passanger_baby" class="form-text font-weight-bold">Child
                                                        Passangers</label>
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" id="passanger_baby"
                                                            name="passanger_baby" placeholder="Adult Passangers"
                                                            min="0" aria-describedby="inputGroup-sizing-sm"
                                                            max="9" value="0" required />
                                                        <div class="input-group-append bg-light"
                                                            id="inputGroup-sizing-sm">
                                                            <span class="input-group-text text-sm">Child</span>
                                                        </div>
                                                    </div>
                                                    <small class="form-text text-muted">
                                                        Child is up to 8 years old
                                                    </small>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>





                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-search fa-fw"></i> <strong>Search</strong>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12">
                    <div class="card card-semi shadow">
                        <div class="card-body">
                            <div class="section-title">
                                <h1><strong>A licensed, Insired and Trusted Transportation Company</strong></h1>
                            </div>
                            <div class="booking-text">
                                <p>More than 15,000 hours driving time. More than 55,000 passengers (have been) served among others from Singapore Airlines, Emirates Airlines, Eva Airline and China Airlines</p>
                            </div>
                            <div class="booking-text">
                                <p>Estimated travel time between Philadelphia and JFK Airport 3.5 hours consistently well maintained (more than 90% within the time frame)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="profile" class="profile section-padding" data-scroll-index="2">
        <div class="container">
            <div class="section-title">
                <h1><strong>Our Services</strong></h1>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="{{ asset('img/ontime.jpg') }}"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <p class="card-text">Whether you???re a business traveller, a couple, a big group of friends
                                or family
                                travelling with lots of luggage, by reserving your airport shuttle or private car you
                                can have the reassurance and security that you???ll be picked up on time and taken
                                straight to your home, hotel or attraction</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="{{ asset('img/drive_safely.jpg') }}" class="card-img-top"
                            alt="">
                        <div class="card-body">
                            <p class="card-text">We drive safely and follow all rules of the road to ensure you have a
                                safe and
                                pleasurable trip</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="{{ asset('img/passenger_pickup.jpg') }}"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <p class="card-text">Passenger Pick Up And Drop Off Services</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@include('layouts.frontend.android')

@endsection
@section('vitamin')
    <script>
        let booking_type = null;
    </script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/booking.js') }}"></script>
@endsection
