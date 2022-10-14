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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="/admin/shuttle/add" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Data
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-bordered datatables">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><i class="fas fa-cogs"></i></th>
                                                <th style="min-width: 120px;">Photo</th>
                                                <th style="min-width: 100px;">From Type</th>
                                                <th style="min-width: 300px;">From Area</th>
                                                <th style="min-width: 300px;">To Area</th>
                                                <th style="min-width: 100px;">Time Departure</th>
                                                <th style="min-width: 100px;">Total Seat</th>
                                                <th style="min-width: 100px;">Luggage Price</th>
                                                <th style="min-width: 120px;">Rent Price</th>
                                                <th style="min-width: 150px;">Vehicle Name</th>
                                                <th style="min-width: 150px;">Vehicle Number</th>
                                                <th style="min-width: 120px;">Driver Contact</th>
                                                <th style="min-width: 200px;">Notes</th>
                                                <th style="min-width: 80px;">Active</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shuttles as $shuttle)
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('admin.shuttle.edit', $shuttle['id']) }}"
                                                            class="btn btn-info btn-sm">
                                                            <i class="fas fa-pencil fa-fw"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            id="delete_{{ $shuttle['id'] }}"
                                                            onclick="deleteData('{{ $shuttle['id'] }}')">
                                                            <i class="fas fa-trash fa-fw"></i>
                                                        </button>
                                                    </td>
                                                    <td><img src="/{{ $shuttle['photo'] }}" alt=""
                                                            class="img-thumbnail"></td>
                                                    <td>{{ $shuttle['from_type'] }}</td>
                                                    <td>{{ $shuttle['from_area'] }}</td>
                                                    <td>{{ $shuttle['to_area'] }}</td>
                                                    <td>{{ $shuttle['time_departure'] }}</td>
                                                    <td>{{ $shuttle['total_seat'] }}</td>
                                                    <td>{{ number_format($shuttle['luggage_price'], 2) }}</td>
                                                    <td>{{ number_format($shuttle['price'], 2) }}</td>
                                                    <td>{{ $shuttle['vehicle_name'] }}</td>
                                                    <td>{{ $shuttle['vehicle_number'] }}</td>
                                                    <td>{{ $shuttle['driver_contact'] }}</td>
                                                    <td>{{ nl2br($shuttle['notes']) }}</td>
                                                    <td>{{ $shuttle['is_active'] ? 'Active' : 'Inactive' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
        const token = $("meta[name='csrf-token']").attr("content");

        $(document).ready(() => {
            $('.datatables').DataTable({
                scrollX: true,
                order: [
                    [2, 'asc']
                ],
                columnDefs: [{
                    targets: [0, 1],
                    orderable: false,
                }]
            })
        })

        function deleteData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/shuttle/delete/${id}`,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        beforeSend: () => {
                            $(`#delete_${id}`).prop('disabled', true)
                        }
                    }).fail(e => {
                        console.log(e.responseText)
                        $(`#delete_${id}`).prop('disabled', false)
                    }).done(e => {
                        Swal.fire({
                            icon: 'success',
                            title: e.message,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true
                        }).then(() => {
                            window.location.reload()
                        })
                    })
                }
            })
        }
    </script>
@endsection
