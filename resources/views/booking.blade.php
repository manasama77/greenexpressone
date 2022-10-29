@extends('layouts.frontend.app')
@section('page_content')
    <section id="home" class="home d-flex align-items-center" data-scroll-index="0">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 mt-5">
                    <h1 class="text-center mt-5">Booking Schedule</h1>
                </div>
            </div>
        </div>
    </section>

    <section id="booking" class="booking section-padding" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-8 mb-5">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="text-center font-weight-bold mb-4">Order Data</h5>
                            <form id="form_booking">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="customer_phone" class="form-text font-weight-bold">Customer
                                                Phone</label>
                                            <input type="tel" class="form-control" id="customer_phone"
                                                name="customer_phone" placeholder="Customer Phone" required />
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_password" class="form-text font-weight-bold">Customer
                                                Password</label>
                                            <input type="password" class="form-control" id="customer_password"
                                                name="customer_password" placeholder="Customer Password" required />
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <label for="customer_name" class="form-text font-weight-bold">Customer
                                                Name</label>
                                            <input type="text" class="form-control" id="customer_name"
                                                name="customer_name" placeholder="Customer Name" required />
                                        </div>
                                        <div class="form-group">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="1"
                                                    id="same_passanger">
                                                <label class="form-check-label" for="same_passanger">
                                                    Customer order also passanger
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="customer_email" class="form-text font-weight-bold">Customer
                                                Email</label>
                                            <input type="email" class="form-control" id="customer_email"
                                                name="customer_email" placeholder="Customer Email" required />
                                        </div>
                                        <hr />
                                        <div class="form-group">
                                            <label for="special_area_id" class="form-text font-weight-bold">Special
                                                Area</label>
                                            <select class="form-control" id="special_area_id" name="special_area_id">
                                                <option value="">-</option>
                                                @foreach ($special_areas as $s)
                                                    <option value="{{ $s->id }}">{{ $s->regional_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="luggage_qty" class="form-text font-weight-bold">Luggage Qty</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="luggage_qty"
                                                    name="luggage_qty" placeholder="Luggage Qty" value="0"
                                                    min="0" max="99" required />
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-dark text-white">Kg</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="flight_number" class="form-text font-weight-bold">Flight
                                                Number</label>
                                            <input type="text" class="form-control" id="flight_number"
                                                name="flight_number" placeholder="Flight Number" />
                                        </div>
                                        <div class="form-group">
                                            <label for="Notes" class="form-text font-weight-bold">Notes</label>
                                            <textarea class="form-control" id="flight_number" name="flight_number" placeholder="Notes"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        @for ($i = 1; $i <= $passanger_total; $i++)
                                            <div class="form-group">
                                                <label for="passanger_name_{{ $i }}"
                                                    class="form-text font-weight-bold">Passanger
                                                    Name {{ $i }}</label>
                                                <input type="text" class="form-control"
                                                    id="passanger_name_{{ $i }}" name="passanger_name[]"
                                                    placeholder="Passanger Name" required />
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fas fa-save fa-fw"></i> Booking
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mb-5">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h3>Departure Detail</h3>
                            <p>From: {{ $from_main_name }} - {{ $from_sub_name }}</p>
                            <p>To: {{ $to_main_name }} - {{ $to_sub_name }}</p>
                            <p>Special Area: <span class="special_area_name">-</span></p>
                            <p>Date: {{ $date_time_departure }}</p>
                            <p>Passanger: {{ $passanger_adult }} Adult {{ $passanger_baby }} Baby</p>
                            <p>Luggage: <span class="luggage_qty"></span> Kg</p>
                            <hr />
                            <table class="table table-borderless text-white">
                                <tbody>
                                    <tr>
                                        <td>
                                            Base Price:<br />
                                            {{ $passanger_total }} Passanger
                                            <input type="hidden" name="passanger_total"
                                                value="{{ $passanger_total }}" />
                                        </td>
                                        <td class="text-right">
                                            ${{ $base_price_total }}
                                            <input type="hidden" name="base_price_total"
                                                value="{{ $base_price_total }}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Special Area Price:<br />
                                            <span class="special_area_name">-</span>
                                        </td>
                                        <td class="text-right">
                                            <span id="special_area_price">$0</span>
                                            <input type="hidden" name="special_area_price" value="0" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Luggage Price:<br />
                                            <span class="luggage_qty"></span> Kg
                                        </td>
                                        <td class="text-right">
                                            <span id="luggage_price">$0</span>
                                            <input type="hidden" name="luggage_base_price"
                                                value="{{ $luggage_price }}" />
                                            <input type="hidden" name="luggage_price" value="0" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Voucher:<br />
                                            <input type="text" class="form-control" id="voucher" name="voucher"
                                                placeholder="Voucher" />
                                        </td>
                                        <td class="text-right">
                                            <span id="voucher_price">$0</span>
                                            <input type="hidden" name="voucher_price" value="0" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <hr />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Sub Total:
                                        </td>
                                        <td class="text-right">
                                            <span id="sub_total">${{ $base_price_total }}</span>
                                            <input type="hidden" name="sub_total" value="{{ $base_price_total }}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Service Fee (3%):
                                        </td>
                                        <td class="text-right">
                                            @php
                                                $service_fee = ($base_price_total * 3) / 100;
                                                $gt = $base_price_total + $service_fee;
                                            @endphp
                                            <span id="service_fee">${{ number_format($service_fee, 2) }}</span>
                                            <input type="hidden" name="service_fee" value="{{ $service_fee }}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Grand Total:
                                        </td>
                                        <td class="text-right">
                                            <span id="grand_total">${{ number_format($gt, 2) }}</span>
                                            <input type="hidden" name="grand_total" value="{{ $gt }}" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="android" class="android section-padding" data-scroll-index="3">
        <div class="container py-5">
            <div class="row py-5">
                <div class="col-sm-6 text-white">
                    <p><img src="img/logo-green-express-one.png" class="img-fluid" width="200px"></p>
                    <h3 class="font-weight-bold">Instal juga aplikasi DayTrans di smartphone android kamu sekarang !
                    </h3>
                    <p>dapatkan kemudahan saat memesan tiket dimanapun kamu berada.</p>
                    <p class="pt-3">
                        <img src="https://www.daytrans.co.id/css/daytrans/images/qr.png" class="img-fluid pr-3"
                            width="150px">
                        <span class="align-bottom"><a
                                href="https://play.google.com/store/apps/details?id=com.trust.android.daytrans"><img
                                    src="https://www.daytrans.co.id/css/daytrans/images/playstorebtn.png"
                                    class="img-fluid bottom-align" width="150px"></a></span>
                    </p>
                </div>
                <div class="col-sm-6 mt-auto mb-auto">
                    <p class="text-center"><img src="https://www.daytrans.co.id/css/daytrans/images/phone.png"
                            class="img-fluid pr-3"></p>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vitamin')
@endsection
