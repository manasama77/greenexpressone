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
        <form id="form_booking">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-8 mb-5">
                        <div class="card shadow-lg">
                            <div class="card-body">
                                <h5 class="text-center font-weight-bold mb-4">Order Data</h5>
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
                                                name="customer_password" placeholder="Customer Password"
                                                autocomplete="new-password" required />
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
                                                    <option value="{{ $s->id }}"
                                                        data-first_person_price="{{ $s->first_person_price }}"
                                                        data-extra_person_price="{{ $s->extra_person_price }}">
                                                        {{ $s->regional_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="luggage_qty" class="form-text font-weight-bold">Luggage Qty</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="luggage_qty"
                                                    name="luggage_qty" placeholder="Luggage Qty" value="0"
                                                    min="0" max="50" required />
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
                                            <label for="notes" class="form-text font-weight-bold">Notes</label>
                                            <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
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
                                            <div class="form-group">
                                                <label for="passanger_phone_{{ $i }}"
                                                    class="form-text font-weight-bold">Passanger
                                                    Phone {{ $i }}</label>
                                                <input type="text" class="form-control"
                                                    id="passanger_phone_{{ $i }}" name="passanger_phone[]"
                                                    placeholder="Passanger Phone" required />
                                            </div>
                                            <hr />
                                        @endfor
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block" id="btn_save">
                                        <i class="fas fa-save fa-fw"></i> Booking
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mb-5">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h3>Departure Detail</h3>
                                <p class="text-capitalize">Booking Type: {{ $request->booking_type }}</p>
                                <p>From: {{ $from_main_name }} - {{ $from_sub_name }}</p>
                                <p>To: {{ $to_main_name }} - {{ $to_sub_name }}</p>
                                <p>Special Area: <span class="special_area_name">-</span></p>
                                <p>Date: {{ $date_time_departure }}</p>
                                <p>Passanger: {{ $passanger_adult }} Adult {{ $passanger_baby }} Baby</p>
                                <p>Luggage: <span class="luggage_qty">0</span> Kg</p>
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
                                                <span class="luggage_qty">0</span> Kg
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
                                                <input type="password" class="form-control" id="agent_password"
                                                    name="agent_password" placeholder="Agent Password"
                                                    autocomplete="new-password" />
                                            </td>
                                            <td class="text-right text-warning font-weight-bold">
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
                                                <input type="hidden" name="sub_total"
                                                    value="{{ $base_price_total }}" />
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
        </form>
    </section>
@endsection
@section('vitamin')
    <script>
        let subTotal = {{ $base_price_total }}
        let serviceFee = {{ $service_fee }}
        let grandTotal = {{ $gt }}

        $(document).ready(() => {
            $('#same_passanger').on('change', () => {
                if ($('#same_passanger:checked').val()) {
                    $('#passanger_name_1').attr('readonly', true).val($('#customer_name').val()).addClass(
                        'bg-secondary text-white')
                } else {
                    $('#passanger_name_1').attr('readonly', false).val('').removeClass(
                        'bg-secondary text-white')
                }
            })

            $('#special_area_id').on('change', e => {
                let special_area_id = $('#special_area_id :selected').val()
                let special_area_name = $('#special_area_id :selected').text()
                let first_person_price = $('#special_area_id :selected').data('first_person_price')
                let extra_person_price = $('#special_area_id :selected').data('extra_person_price')
                let passanger_total = $('input[name="passanger_total"]').val()
                let passanger_first = 1
                let passanger_extra = passanger_total - 1;
                if (passanger_extra < 0) {
                    passanger_extra = 0
                }
                let a = passanger_first * first_person_price
                let b = passanger_extra * extra_person_price
                let c = a + b
                let cFormated = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(c)

                if (special_area_id) {
                    $('.special_area_name').text(special_area_name)
                    $('#special_area_price').text(cFormated)
                    $('input[name="special_area_price"]').val(c)
                    generateGrandTotal()
                } else {
                    $('.special_area_name').text('-')
                    $('#special_area_price').text('$0')
                    $('input[name="special_area_price"]').val(0)
                    generateGrandTotal()
                }
            })

            $('#luggage_qty').on('change', e => {
                let luggage_qty = parseFloat($('#luggage_qty').val())
                let luggage_base_price = $('input[name="luggage_base_price"]').val()
                let lp = luggage_qty * luggage_base_price
                let lpFormated = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(lp)
                $('.luggage_qty').text(luggage_qty)
                $('.luggage_qty').text(luggage_qty)
                $('input[name="luggage_price"]').val(lp)
                $('#luggage_price').text(lpFormated)
                generateGrandTotal()
            })

            $('#voucher').on('change', e => {
                let voucher_code = $('#voucher').val()
                let agent_password = $('#agent_password').val()
                if (voucher_code.length > 0 && agent_password.length > 0) {
                    checkVoucher(voucher_code, agent_password)
                } else {
                    $('#voucher_price').text('$0')
                    $('input[name="voucher_price"]').val(0)
                    generateGrandTotal()
                }
            })

            $('#agent_password').on('change', e => {
                let voucher_code = $('#voucher').val()
                let agent_password = $('#agent_password').val()
                if (voucher_code.length > 0 && agent_password.length > 0) {
                    checkVoucher(voucher_code, agent_password)
                } else {
                    $('#voucher_price').text('$0')
                    $('input[name="voucher_price"]').val(0)
                    generateGrandTotal()
                }
            })

            $('#form_booking').on('submit', e => {
                e.preventDefault()
                bookingNow()
            })
        })

        function generateGrandTotal() {
            let base_price_total = parseFloat($('input[name="base_price_total"]').val())
            let special_area_price = parseFloat($('input[name="special_area_price"]').val())
            let luggage_price = parseFloat($('input[name="luggage_price"]').val())
            let voucher_price = parseFloat($('input[name="voucher_price"]').val())

            let st = base_price_total + special_area_price + luggage_price - voucher_price
            let stFormated = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(st)
            subTotal = st
            $('#sub_total').text(stFormated)
            $('input[name="sub_total"]').val(subTotal)

            let sf = (subTotal * 3) / 100
            let sfFormated = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(sf)
            serviceFee = sf
            $('#service_fee').text(sfFormated)
            $('input[name="service_fee"]').val(serviceFee)

            let gt = st + sf
            let gtFormated = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD'
            }).format(gt)
            grandTotal = gt
            $('#grand_total').text(gtFormated)
            $('input[name="grand_total"]').val(grandTotal)

        }

        function checkVoucher(voucher_code, agent_password) {
            $.ajax({
                url: '/api/check_voucher',
                method: 'get',
                dataType: 'json',
                data: {
                    voucher_code: voucher_code,
                    password: agent_password,
                }
            }).fail(e => {
                console.log(e.responseText)
            }).done(e => {
                if (e.success === false) {
                    $('#voucher_price').text('$0')
                    $('input[name="voucher_price"]').val(0)
                    generateGrandTotal()

                    return Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: e.message,
                        showConfirmButton: false,
                        toast: true,
                        timer: 3000,
                    })
                }

                let discount_type = e.data.discount_type
                let discount_value = parseFloat(e.data.discount_value)

                let nilaiDiskon = 0
                if (discount_type == "percentage") {
                    nilaiDiskon = (subTotal * discount_value) / 100
                } else if (discount_type == "value") {
                    nilaiDiskon = discount_value
                }

                let dcFormated = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD'
                }).format(nilaiDiskon)

                $('#voucher_price').text(dcFormated)
                $('input[name="voucher_price"]').val(nilaiDiskon)
                generateGrandTotal()
            })
        }

        function bookingNow() {
            let arrPassangerName = $("input[name='passanger_name[]']").map(function() {
                return $(this).val();
            }).get()

            let arrPassangerPhone = $("input[name='passanger_phone[]']").map(function() {
                return $(this).val();
            }).get()

            let arrPassanger = arrPassangerName.map((v, i) => {
                return {
                    name: v,
                    phone: arrPassangerPhone[i],
                }
            })

            $.ajax({
                url: '/api/booking',
                method: 'post',
                dataType: 'json',
                data: {
                    schedule_type: `{{ session('booking_type') }}`,
                    from_type: `{{ session('from_type') }}`,
                    schedule_id: `{{ session('schedule_id') }}`,
                    date_departure: `{{ session('date_departure') }}`,
                    from_master_area_id: `{{ session('from_master_area_id') }}`,
                    from_master_sub_area_id: `{{ session('from_master_sub_area_id') }}`,
                    to_master_area_id: `{{ session('to_master_area_id') }}`,
                    to_master_sub_area_id: `{{ session('to_master_sub_area_id') }}`,
                    qty_adult: `{{ session('passanger_adult') }}`,
                    qty_baby: `{{ session('passanger_baby') }}`,
                    special_request: ($('#special_area_id').val()) ? 1 : 0,
                    special_area_id: $('#special_area_id').val(),
                    luggage_qty: $('#luggage_qty').val(),
                    flight_number: $('#flight_number').val(),
                    notes: $('#notes').val(),
                    voucher_code: $('#voucher').val(),
                    agent_password: $('#agent_password').val(),
                    customer_phone: $('#customer_phone').val(),
                    customer_password: $('#customer_password').val(),
                    customer_name: $('#customer_name').val(),
                    customer_email: $('#customer_email').val(),
                    passanger: arrPassanger
                },
                beforeSend: function() {
                    $.blockUI()
                    $('#btn_save').prop('disabled', true)
                }
            }).fail(e => {
                $.unblockUI()
                $('#btn_save').prop('disabled', false)
                console.log(e.responseText)
            }).done(e => {
                if (e.success === false) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: e.message,
                        showConfirmButton: false,
                        toast: true,
                        timer: 3000,
                    });
                    $('#btn_save').prop('disabled', false)
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: e.message,
                        showConfirmButton: false,
                        toast: true,
                        timer: 3000,
                    }).then(() => {
                        window.location.replace(`/booking/check?code=${e.data.booking_number_encode}`);
                    });
                }
                $.unblockUI()
            })
        }
    </script>
@endsection
