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
        <img src="img/8493.jpg" class="bg" loading="lazy" />
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 mb-5">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h5 class="text-center font-weight-bold mb-4">Airport Shuttle & Charter Booking</h5>
                            <form id="form_booking" action="{{ route('search') }}" method="get">
                                <div class="form-group">
                                    <label for="from_type" class="form-text font-weight-bold">From Type</label>
                                    <select class="form-control select2" id="from_type" name="from_type"
                                        data-placeholder="From Type" required>
                                        <option value="airport">Airport</option>
                                        <option value="district">District</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="from_master_area_id"
                                        class="form-text font-weight-bold">From/Departure</label>
                                    <select class="form-control select2" id="from_master_area_id" name="from_master_area_id"
                                        data-placeholder="From/Departure" required disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="from_master_sub_area_id" class="form-text font-weight-bold">Sub
                                        From/Departure</label>
                                    <select class="form-control select2" id="from_master_sub_area_id"
                                        name="from_master_sub_area_id"
                                        data-placeholder="Sub
                                        From/Departure"
                                        disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="to_master_area_id" class="form-text font-weight-bold">To/Arrival</label>
                                    <select class="form-control select2" id="to_master_area_id" name="to_master_area_id"
                                        data-placeholder="To/Arrival" required disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="to_master_sub_area_id" class="form-text font-weight-bold">Sub
                                        To/Arrival</label>
                                    <select class="form-control select2" id="to_master_sub_area_id"
                                        name="to_master_sub_area_id"
                                        data-placeholder="Sub
                                        To/Arrival" disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="form-group text-center">
                                    <div class="form-check form-check-inline">
                                        <input {{ $request->booking_type == 'shuttle' ? 'checked' : null }}
                                            class="form-check-input" type="radio" name="booking_type" id="shuttle"
                                            value="shuttle" checked>
                                        <label {{ $request->booking_type == 'charter' ? 'checked' : null }}
                                            class="form-check-label" for="shuttle">Shuttle</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="booking_type" id="charter"
                                            value="charter">
                                        <label class="form-check-label" for="charter">Charter</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="date_departure" class="form-text font-weight-bold">Outward
                                        journey</label>
                                    <input type="date" class="form-control" id="date_departure" name="date_departure"
                                        value="{{ $request->date_departure }}" placeholder="Outward Journey" required />
                                </div>
                                <div class="form-group">
                                    <label for="passanger_adult" class="form-text font-weight-bold">Adult
                                        Passangers</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="passanger_adult"
                                            name="passanger_adult" value="{{ $request->passanger_adult }}"
                                            placeholder="Adult Passangers" min="1" max="9" value="1"
                                            required />
                                        <div class="input-group-append bg-light">
                                            <span class="input-group-text">Adult
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="passanger_baby" class="form-text font-weight-bold">Baby
                                        Passangers</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="passanger_baby"
                                            name="passanger_baby" value="{{ $request->passanger_baby }}"
                                            placeholder="Adult Passangers" min="0" max="9" value="0"
                                            required />
                                        <div class="input-group-append bg-light">
                                            <span class="input-group-text">Baby
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
                <div class="col-sm-12 col-md-8">
                    <div class="card card-semi shadow">
                        <div class="card-body">
                            <div class="section-title">
                                <h1>Shuttle bus to and from the main America airports</h1>
                                <div id="list_jadwal"></div>
                            </div>
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
    <script>
        // global variable
        let from_type = ('{{ $request->from_type }}') ?? null;
        let from_master_area_id = ('{{ $request->from_master_area_id }}') ?? null;
        let from_master_sub_area_id = ('{{ $request->from_master_sub_area_id }}') ?? null;
        let to_master_area_id = ('{{ $request->to_master_area_id }}') ?? null;
        let to_master_sub_area_id = ('{{ $request->to_master_sub_area_id }}') ?? null;
        let booking_type = ('{{ $request->booking_type }}') ?? null;
        let date_departure = ('{{ $request->date_departure }}') ?? null;
        let passanger_adult = ('{{ $request->passanger_adult }}') ?? null;
        let passanger_baby = ('{{ $request->passanger_baby }}') ?? null;
        let list_jadwal_container = $('#list_jadwal_container').val()

        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
            })

            $('#from_type').on('change', e => {
                e.preventDefault();
                if ($('#from_type').val()) {
                    getFromList()
                } else {
                    $('#from_master_area_id').val(null).trigger('change').prop('disabled', true)
                    $('#from_master_sub_area_id').val(null).trigger('change').prop('disabled', true)
                    $('#to_master_area_id').val(null).trigger('change').prop('disabled', true)
                    $('#to_master_sub_area_id').val(null).trigger('change').prop('disabled', true)
                }
            })

            $('#from_master_area_id').on('change', e => {
                if ($('#from_master_area_id').val()) {
                    console.log("a")
                    let master_area_id = $('#from_master_area_id').val()
                    getSubArea(master_area_id, '#from_master_sub_area_id')
                } else {
                    console.log("b")
                    $('#from_master_sub_area_id').val(null).trigger('change').prop('disabled', true)
                }
            })

            $('#to_master_area_id').on('change', e => {
                if ($('#to_master_area_id').val()) {
                    let master_area_id = $('#to_master_area_id').val()
                    getSubArea(master_area_id, '#to_master_sub_area_id')
                } else {
                    $('#to_master_sub_area_id').val(null).trigger('change').prop('disabled', true)
                }
            })

            initData()
        });

        function initData() {
            $.blockUI()
            if (from_type && from_master_area_id && to_master_area_id && booking_type && date_departure &&
                passanger_adult) {
                $('#from_type').val(from_type)

                $.ajax({
                    url: `${base_url}api/get_list_from_departure`,
                    method: 'get',
                    dataType: 'json',
                    data: {
                        from_type: $('#from_type').val()
                    },
                    beforeSend: () => {
                        $('#from_master_area_id').html('<option value=""></option>').prop('disabled', true)
                        $('#from_master_sub_area_id').html('<option value=""></option>').prop('disabled', true)
                    }
                }).fail(e => {
                    console.log(e.responseText)
                }).done(e => {
                    let data = e.data
                    let htmlnya = '<option value=""></option>';

                    data.forEach(x => {
                        let id = x.id
                        let name = x.name
                        let sub_area = x.sub_area
                        htmlnya += `<option value="${id}">${name}</option>`
                    })
                    $('#from_master_area_id').html(htmlnya).prop('disabled', false)
                    $('#from_master_area_id').val(from_master_area_id)

                    $.ajax({
                        url: `${base_url}api/get_list_sub_area`,
                        method: 'get',
                        dataType: 'json',
                        data: {
                            master_area_id: $("#from_master_area_id").val()
                        },
                        beforeSend: () => {
                            $(`#from_master_sub_area_id`).html('<option value=""></option>').prop(
                                'disabled', true)
                        }
                    }).fail(e => {
                        console.log(e.responseText)
                    }).done(e => {
                        let data = e.data
                        let htmlnya = '<option value=""></option>';

                        data.forEach(x => {
                            let id = x.id
                            let name = x.name
                            htmlnya += `<option value="${id}">${name}</option>`
                        })
                        $(`#from_master_sub_area_id`).html(htmlnya).prop('disabled', false)
                        $('#from_master_sub_area_id').val(from_master_sub_area_id)

                        $.ajax({
                            url: `${base_url}api/get_list_to_destination`,
                            method: 'get',
                            dataType: 'json',
                            data: {
                                from_type: $('#from_type').val()
                            },
                            beforeSend: () => {
                                $('#to_master_area_id').html('<option value=""></option>').prop(
                                    'disabled', true)
                                $('#to_master_sub_area_id').html('<option value=""></option>')
                                    .prop('disabled', true)
                            }
                        }).fail(e => {
                            console.log(e.responseText)
                        }).done(e => {
                            let data = e.data
                            let htmlnya = '<option value=""></option>';

                            data.forEach(x => {
                                let id = x.id
                                let name = x.name
                                htmlnya += `<option value="${id}">${name}</option>`
                            })
                            $('#to_master_area_id').html(htmlnya).prop('disabled', false)
                            $('#to_master_area_id').val(to_master_area_id)

                            $.ajax({
                                url: `${base_url}api/get_list_sub_area`,
                                method: 'get',
                                dataType: 'json',
                                data: {
                                    master_area_id: $('#to_master_area_id').val()
                                },
                                beforeSend: () => {
                                    $(`#to_master_sub_area_id`).html(
                                            '<option value=""></option>')
                                        .prop('disabled', true)
                                }
                            }).fail(e => {
                                console.log(e.responseText)
                            }).always(e => {
                                $.unblockUI()
                            }).done(e => {
                                let data = e.data
                                let htmlnya = '<option value=""></option>';

                                data.forEach(x => {
                                    let id = x.id
                                    let name = x.name
                                    htmlnya +=
                                        `<option value="${id}">${name}</option>`
                                })
                                $(`#to_master_sub_area_id`).html(htmlnya).prop('disabled',
                                    false)
                                $(`#to_master_sub_area_id`).val(to_master_sub_area_id)

                                getScheduleShuttle()
                            })
                        })
                    })
                })
            }
            // getFromList()
        }

        function getFromList() {
            $.ajax({
                url: `${base_url}api/get_list_from_departure`,
                method: 'get',
                dataType: 'json',
                data: {
                    from_type: $('#from_type').val()
                },
                beforeSend: () => {
                    $('#from_master_area_id').html('<option value=""></option>').prop('disabled', true)
                    $('#from_master_sub_area_id').html('<option value=""></option>').prop('disabled', true)
                }
            }).fail(e => {
                console.log(e.responseText)
            }).done(e => {
                console.log(e)
                let data = e.data
                let htmlnya = '<option value=""></option>';

                data.forEach(x => {
                    let id = x.id
                    let name = x.name
                    let sub_area = x.sub_area
                    htmlnya += `<option value="${id}">${name}</option>`
                })
                $('#from_master_area_id').html(htmlnya).prop('disabled', false)

                getToList()
            })
        }

        function getToList() {
            $.ajax({
                url: `${base_url}api/get_list_to_destination`,
                method: 'get',
                dataType: 'json',
                data: {
                    from_type: $('#from_type').val()
                },
                beforeSend: () => {
                    $('#to_master_area_id').html('<option value=""></option>').prop('disabled', true)
                    $('#to_master_sub_area_id').html('<option value=""></option>').prop('disabled', true)
                }
            }).fail(e => {
                console.log(e.responseText)
            }).done(e => {
                console.log(e)
                let data = e.data
                let htmlnya = '<option value=""></option>';

                data.forEach(x => {
                    let id = x.id
                    let name = x.name
                    htmlnya += `<option value="${id}">${name}</option>`
                })
                $('#to_master_area_id').html(htmlnya).prop('disabled', false)
            })
        }

        function getSubArea(master_area_id, selector) {
            $.ajax({
                url: `${base_url}api/get_list_sub_area`,
                method: 'get',
                dataType: 'json',
                data: {
                    master_area_id
                },
                beforeSend: () => {
                    $(`${selector}`).html('<option value=""></option>').prop('disabled', true)
                }
            }).fail(e => {
                console.log(e.responseText)
            }).done(e => {
                console.log(e)
                let data = e.data
                let htmlnya = '<option value=""></option>';

                data.forEach(x => {
                    let id = x.id
                    let name = x.name
                    htmlnya += `<option value="${id}">${name}</option>`
                })
                $(`${selector}`).html(htmlnya).prop('disabled', false)
            })
        }

        function getScheduleShuttle() {
            $.ajax({
                url: `${base_url}api/get_list_sub_area`,
                method: 'get',
                dataType: 'json',
                data: {
                    master_area_id
                },
                beforeSend: () => {
                    $(`${selector}`).html('<option value=""></option>').prop('disabled', true)
                }
            }).fail(e => {
                console.log(e.responseText)
            }).done(e => {
                console.log(e)
                let data = e.data
                let htmlnya = '<option value=""></option>';

                data.forEach(x => {
                    let id = x.id
                    let name = x.name
                    htmlnya += `<option value="${id}">${name}</option>`
                })
                $(`${selector}`).html(htmlnya).prop('disabled', false)
            })
        }
    </script>
@endsection
