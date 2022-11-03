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
                                    <h3>Process the Payment</h3>
                                    <div class="alert alert-warning" role="alert">
                                        <span class="font-weight-bold">Accept Visa, Mastercard, American Express, Discover, Diners Club, JCB, and China UnionPay</span>
                                        payments from customers worldwide.
                                    </div>
                                    <form role="form" action="{{ route('booking.process') }}" method="post"
                                          class="validation form-row"
                                          data-cc-on-file="false"
                                          data-stripe-publishable-key="{{ env('STRIPE_KEY') }}"
                                          id="payment-form">

                                        @csrf
                                        <input type="hidden" name="hcode" value="{{request('hcode')}}">
                                        <div class="form-group col-sm-12">
                                            <label for="name">Name on card</label>
                                            <input type="text" class="form-control required" id="name"
                                                   placeholder="Name on card"
                                                   autocomplete="off">
                                        </div>

                                        <div class="form-group col-sm-12">
                                            <label for="card_number">Card number</label>
                                            <input type="text" class="form-control required card_number"
                                                   id="card_number" name="card_number"
                                                   placeholder="Card Number" autocomplete="off">
                                            <div>
                                                <small class="type_card d-none"></small>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label for="cvc">CVC/CVV</label>
                                            <input type="text" class="form-control required" id="cvc" name="cvc" maxlength="4"
                                                   placeholder="e,g 415" autocomplete="off">
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label for="expiry_month">Expiration Month</label>
                                            <input type="text" class="form-control required" id="expiry_month"
                                                   name="expiry_month" placeholder="MM" autocomplete="off" maxlength="2">
                                        </div>

                                        <div class="form-group col-sm-4">
                                            <label for="expiry_year">Expiration Year</label>
                                            <input type="text" class="form-control required" id="expiry_year" maxlength="2"
                                                   name="expiry_year"
                                                   placeholder="YYYY" autocomplete="off">
                                        </div>

                                        @if (session('message'))
                                            {!! session('message') !!}
                                        @endif

                                        <div class='form-row row'>
                                            <div class='col-md-12 d-none error form-group'>
                                                <div class="alert alert-danger" role="alert">
                                                    Fix the errors before you begin.
                                                </div>
                                            </div>
                                        </div>

                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Pay Now
                                            ($ {{$bookings->total_price}})
                                        </button>

                                    </form>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('vitamin')
    {{-- manipulate dom and stripe logic   --}}
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.payform.js') }}"></script>
    <script>
        $(document).ready(function () {
            var $form = $("#payment-form");
            $('#card_number').payform('formatCardNumber');
            $('#cvc').payform('formatCardCVC');
            $('#expiry_month').payform('formatNumeric');
            $('#expiry_year').payform('formatNumeric');

            $("#card_number").on('keyup', function () {
                let valid = $.payform.validateCardNumber($(this).val());

                if (valid) {
                    $(this).removeClass('is-invalid')
                    $(this).addClass('is-valid')
                } else {
                    $(this).addClass('is-invalid')
                    $(this).removeClass('is-valid')
                }

                let type = $.payform.parseCardType($(this).val());

                type ? $('.type_card').html(`Type : ${type}`).removeClass('d-none').addClass('text-success') : $('.type_card').addClass('d-none')
            })

            $("#cvc").on('keyup', function () {
                let valid = $.payform.validateCardCVC($(this).val())
                if (valid) {
                    $(this).removeClass('is-invalid')
                    $(this).addClass('is-valid')
                } else {
                    $(this).addClass('is-invalid')
                    $(this).removeClass('is-valid')
                }

            })

            $('#expiry_month').on('keyup', function(){
                let valid =$.payform.validateCardExpiry($(this).val(), $('#expiry_year').val())
                if (valid) {
                    $(this).removeClass('is-invalid')
                    $(this).addClass('is-valid')
                } else {
                    $(this).addClass('is-invalid')
                    $(this).removeClass('is_valid')
                }
            })

            $('#expiry_year').on('keyup', function(){
                let valid =$.payform.validateCardExpiry($('#expiry_month').val(), $(this).val())
                if (valid) {
                    $(this).removeClass('is-invalid')
                    $(this).addClass('is-valid')
                    $('#expiry_month').removeClass('is-invalid')
                    $('#expiry_month').addClass('is-valid')
                } else {
                    $(this).addClass('is-invalid')
                    $(this).removeClass('is_valid')
                    $('#expiry_month').addClass('is-invalid')
                    $('#expiry_month').removeClass('is_valid')
                }
            })

            $('form.validation').bind('submit', function (e) {
                var $form = $(".validation"),
                    inputVal = ['input[type=email]', 'input[type=password]',
                        'input[type=text]', 'input[type=file]',
                        'textarea'].join(', '),
                    $inputs = $form.find('.required').find(inputVal),
                    $errorStatus = $form.find('div.error'),
                    valid = true;
                $errorStatus.addClass('d-none');

                $('input').removeClass('is_invalid');
                $inputs.each(function (i, el) {
                    var $input = $(el);
                    if ($input.val() === '') {
                        $input.addClass('is_invalid');
                        $errorStatus.removeClass('d-none');
                        e.preventDefault();
                    }
                });

                if (!$form.data('cc-on-file')) {
                    e.preventDefault();
                    Stripe.setPublishableKey($form.data('stripe-publishable-key'));
                    Stripe.createToken({
                        number: $('#card_number').val(),
                        cvc: $('#cvc').val(),
                        exp_month: $('#expiry_month').val(),
                        exp_year: $('#expiry_year').val()
                    }, stripeHandleResponse);
                }

            });

            function stripeHandleResponse(status, response) {
                if (response.error) {
                    $('.error')
                        .removeClass('d-none')
                        .find('.alert')
                        .text(response.error.message);
                } else {
                    var token = response['id'];
                    $form.find('input[type=text]').empty();
                    $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                    $form.get(0).submit();
                }
            }
        })
    </script>
@endsection
