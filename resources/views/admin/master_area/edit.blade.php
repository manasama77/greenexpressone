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
                                <h1 class="card-title">Edit Data</h1>
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
                                <form id="form_add" method="POST"
                                    action="{{ route('admin.master_area.update', $master_area->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group mt-2">
                                        <label for="name">Master Area Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            minlength="3" maxlength="100" value="{{ old('url') ?? $master_area->name }}"
                                            required />
                                    </div>
                                    <div class="form-group">
                                        <label for="area_type">Area Type</label>
                                        <select class="form-control" id="area_type" name="area_type" required>
                                            <option value="departure"
                                                {{ $master_area->area_type == 'departure' ? 'selected' : null }}>
                                                Departure</option>
                                            <option value="arrival"
                                                {{ $master_area->area_type == 'arrival' ? 'selected' : null }}>
                                                Arrival</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_active">Active</label>
                                        <select class="form-control" id="is_active" name="is_active" required>
                                            <option value="1" {{ $master_area->is_active == '1' ? 'selected' : null }}>
                                                Active</option>
                                            <option value="0" {{ $master_area->is_active == '0' ? 'selected' : null }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-save fa-fw"></i> Save
                                        </button>
                                        <a href="{{ route('admin.master_area') }}" class="btn btn-secondary btn-block">
                                            <i class="fas fa-backward fa-fw"></i> Back
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
        $(document).ready(() => {})
    </script>
@endsection
