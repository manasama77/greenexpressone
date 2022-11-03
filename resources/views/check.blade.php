@extends('layouts.frontend.app')
@section('page_content')
    <section id="home" class="home d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 my-3 text-center">
                    <h1 class="text-center mt-5">Booking Info - {{ $bookings->booking_number }}</h1>
                </div>
                <div class="col-12 mb-5">
                    <div class="card bg-light shadow">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-md-8">
                                    @if (session('message'))
                                        {!! session('message') !!}
                                    @endif
                                    <h3>Departure Detail</h3>
                                    <p>From: {{ $bookings->from_master_area_name }}
                                        {{ $bookings->from_master_sub_area_name }}
                                    </p>
                                    <p>
                                        To: {{ $bookings->to_master_area_name }} {{ $bookings->to_master_sub_area_name }}</p>
                                    <p>Special Area: {{ $bookings->regional_name ?? '-' }}</p>
                                    <p>Date: {{ $bookings->datetime_departure }}</p>
                                    <p>Passanger: {{ $bookings->qty_adult }} Adult {{ $bookings->qty_baby }} Baby
                                    </p>
                                    <p>Luggage: {{ $bookings->luggage_qty ?? '0' }} Kg</p>
                                    <p>Flight Number: {{ $bookings->flight_number }}</p>
                                    <p>Notes: {{ $bookings->notes }}</p>
                                    <hr/>
                                    <p class="text-capitalize">Booking Status: {{ $bookings->booking_status }}</p>
                                    <p class="text-capitalize">Payment Status: {{ $bookings->payment_status }}</p>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <h3>Price Detail</h3>
                                    <table class="table table-bordered bg-dark text-white">
                                        <tbody>
                                        <tr>
                                            <td>
                                                Base Price:<br/>
                                                @php
                                                    $passanger_total = $bookings->qty_adult + $bookings->qty_baby;
                                                @endphp
                                                {{ $passanger_total }} Passanger
                                            </td>
                                            <td class="text-right">
                                                ${{ $bookings->total_base_price }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Special Area Price:<br/>
                                                {{ $bookings->regional_name }}
                                            </td>
                                            <td class="text-right">
                                                ${{ $bookings->extra_price }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Luggage Price:<br/>
                                                {{ $bookings->luggage_qty ?? '0' }} Kg
                                            </td>
                                            <td class="text-right">
                                                ${{ $bookings->luggage_price ?? '0' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Voucher:<br/>
                                                {{ $vouchers->code ?? '' }}  {{-- adding condition when user doesn't input voucher when creating booking --}}
                                            </td>
                                            <td class="text-right text-warning font-weight-bold">
                                                ${{ $bookings->promo_price }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Sub Total:
                                            </td>
                                            <td class="text-right">
                                                ${{ $bookings->sub_total_price }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Service Fee (3%):
                                            </td>
                                            <td class="text-right">
                                                ${{ $bookings->fee_price }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">
                                                Grand Total:
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                ${{ $bookings->total_price }}
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <div class="py-auto"><p class="small font-italic">Created
                                    at: {{ $bookings->created_at }}</p></div>
                            <div class="d-flex align-item-center">
                                @if($bookings->payment_status == 'waiting')
                                    <a href="{{ route("booking.payment", ['hcode' => $hashed_code])  }}"
                                       class="btn btn-sm btn-primary mb-1">Process Transaction <i
                                            class="fab fa-cc-stripe"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vitamin')
@endsection
