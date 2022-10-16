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
                                        <input class="form-check-input" type="radio" name="booking_type" id="shuttle"
                                            value="shuttle" checked>
                                        <label class="form-check-label" for="shuttle">Shuttle</label>
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
                                        placeholder="Outward Journey" required />
                                </div>
                                <div class="form-group">
                                    <label for="passanger_adult" class="form-text font-weight-bold">Adult
                                        Passangers</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="passanger_adult"
                                            name="passanger_adult" placeholder="Adult Passangers" min="1"
                                            max="9" value="1" required />
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
                                            name="passanger_baby" placeholder="Adult Passangers" min="0"
                                            max="9" value="0" required />
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
                            </div>
                            <div class="booking-text">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Praesentium mollitia eum
                                    ducimus
                                    accusamus, nisi repellat distinctio iusto deleniti, saepe, nobis ex reprehenderit?
                                    Pariatur
                                    cupiditate consequatur unde exercitationem, sit a adipisci molestias labore,
                                    officiis
                                    repudiandae esse voluptate eveniet magni laborum vel. Labore magni modi sit fugiat
                                    neque!
                                    Quo eligendi corporis in, repudiandae molestias dignissimos eum recusandae officiis,
                                    atque
                                    incidunt hic? Optio possimus ut laudantium accusamus reprehenderit dolorem mollitia
                                    sed
                                    aliquam explicabo corrupti? Quisquam nisi vitae, quod quibusdam libero quas quidem
                                    molestiae. Aspernatur ad fuga itaque. Amet enim recusandae blanditiis aliquid
                                    tenetur natus
                                    fugiat, distinctio quae! Sit sapiente a corrupti praesentium ea in ipsam cupiditate
                                    dolor
                                    atque, at saepe soluta reiciendis vel qui eligendi dignissimos repudiandae nemo
                                    ipsa, modi,
                                    exercitationem ullam quasi? Architecto similique, quasi, tempore placeat, laudantium
                                    minus
                                    sapiente vel laborum tempora fuga eligendi alias velit qui maxime molestiae labore
                                    omnis
                                    quia! Alias corporis pariatur quae minima? Iste, ex tempore nulla perferendis nisi
                                    explicabo
                                    incidunt illo aliquam accusantium unde dolorem possimus harum est ipsam tenetur
                                    corporis
                                    neque, magnam laudantium obcaecati atque suscipit. Ea obcaecati cumque deserunt
                                    alias
                                    officiis, esse ipsum quibusdam accusantium suscipit nihil saepe aliquam eaque maxime
                                    veniam
                                    magni minus soluta ullam aliquid? Iure aperiam, itaque dolores consectetur qui
                                    saepe.</p>
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
                <h1>Our Services</h1>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="https://greenexpressone.com/wp-content/uploads/2022/04/Picture2.png"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <p class="card-text">Whether you’re a business traveller, a couple, a big group of friends
                                or family
                                travelling with lots of luggage, by reserving your airport shuttle or private car you
                                can have the reassurance and security that you’ll be picked up on time and taken
                                straight to your home, hotel or attraction</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card card-shadow">
                        <img src="https://greenexpressone.com/wp-content/uploads/2022/04/green.jpg" class="card-img-top"
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
                        <img src="https://greenexpressone.com/wp-content/uploads/2022/04/istockphoto-1206670377-640x640-1-300x169.jpg"
                            class="card-img-top" alt="">
                        <div class="card-body">
                            <p class="card-text">Passenger Pick Up And Drop Off Services</p>
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

        let from_type = 'airport'
        let from_area_id = null

        $(document).ready(function() {
            $('.select2').select2({
                allowClear: true,
            })

            initData()

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
        });

        function initData() {
            getFromList()
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
    </script>
@endsection
