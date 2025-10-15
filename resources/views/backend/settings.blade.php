@extends('backend.backend-main')

@section('title')
    {{ __('System Settings') }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">System Settings</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-7">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add School</h4>
                    <form class="row g-2 align-items-center" method="POST" action="{{ route('management.add.school') }}">
                        @csrf

                        <x-flash-message type="success" />
                        <x-flash-message type="error" />

                        <div class="col-12 col-sm-9">
                            <input type="text" class="form-control" name="school" placeholder="eg Secondary School">
                        </div>

                        <div class="col-12 col-sm-3">
                            <button type="submit" class="btn btn-primary w-100">Add School</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div>
@endsection
