@extends('layouts.app')
@section('content')
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h2 class="content-header-title float-left mb-0">{{ $page_title }}</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4 offset-md-4">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="pb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success">
                                        <div class="alert-body">
                                            {{ $message }}
                                        </div>
                                    </div>
                                @endif
                                <form id="form_add" method="POST" action="/admin/charter">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">From Type</label>
                                        <select class="form-control" id="from_type" name="from_type" required>
                                            <option value=""></option>
                                            <option value="airport">Airport</option>
                                            <option value="district">District</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="from_master_area_id">From Master Area</label>
                                        <select class="form-control select2" id="from_master_area_id"
                                            name="from_master_area_id" data-placeholder="Select From Master Area" required
                                            disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="from_master_sub_area_id">From Master Sub Area</label>
                                        <select class="form-control select2" id="from_master_sub_area_id"
                                            name="from_master_sub_area_id" data-placeholder="Select From Master Sub Area"
                                            required disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="to_master_area_id">To Master Area</label>
                                        <select class="form-control select2" id="to_master_area_id" name="to_master_area_id"
                                            data-placeholder="Select To Master Area" required disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="to_master_sub_area_id">To Master Sub Area</label>
                                        <select class="form-control select2" id="to_master_sub_area_id"
                                            name="to_master_sub_area_id" data-placeholder="Select To Master Sub Area"
                                            required disabled>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="vehicle_name">Vehicle Name</label>
                                        <input type="text" class="form-control" id="vehicle_name" name="vehicle_name"
                                            value="{{ old('vehicle_name') }}" minlength="3" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="vehicle_number">Vehicle Number</label>
                                        <input type="text" class="form-control" id="vehicle_number" name="vehicle_number"
                                            value="{{ old('vehicle_number') }}" minlength="3" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="price" name="price"
                                            min="0.01" max="9999.99" step="0.01" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="photo">Photo</label>
                                        <input type="file" class="form-control" id="photo" name="photo"
                                            accept="image/*" />
                                    </div>
                                    <div class="form-group">
                                        <label for="driver_contact">Driver Contact</label>
                                        <input type="text" class="form-control" id="driver_contact" name="driver_contact"
                                            value="{{ old('driver_contact') }}" minlength="3" />
                                    </div>
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes">{{ old('notes') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_available">Available</label>
                                        <select class="form-control" id="is_available" name="is_available" required>
                                            <option value="1">Available</option>
                                            <option value="0">Not Available</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-save fa-fw"></i> Save
                                        </button>
                                        <a href="/admin/charter" class="btn btn-secondary btn-block">
                                            <i class="fas fa-backward fa-fw"></i> Back to list
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(() => {
            $('#from_master_area_id').select2({
                allowclear: true
            })

            $('#from_master_sub_area_id').select2({
                allowclear: true
            })

            $('#to_master_area_id').select2({
                allowclear: true
            })

            $('#to_master_sub_area_id').select2({
                allowclear: true
            })

            $('#from_type').on('change', e => {
                e.preventDefault();
                if ($('#from_type').val()) {
                    getFromList()
                    getToList()
                }
            })
        })

        function getFromList() {
            $.ajax({
                url: `{{ $base_url }}api/get_list_from_departure`,
                method: 'get',
                dataType: 'json',
                data: {
                    from_type: $('#from_type').val()
                },
                beforeSend: () => {
                    $('#from_master_area_id').html('<option value=""></option>').prop('disabled', true)
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
                $('#from_master_area_id').html(htmlnya).prop('disabled', false)
            })
        }

        function getToList() {
            $.ajax({
                url: `{{ $base_url }}api/get_list_to_destination`,
                method: 'get',
                dataType: 'json',
                data: {
                    from_type: $('#from_type').val()
                },
                beforeSend: () => {
                    $('#to_master_area_id').html('<option value=""></option>').prop('disabled', true)
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
    </script>
@endsection