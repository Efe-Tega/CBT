@extends('backend.backend-main')

@section('title')
    @auth('teacher')
        {{ __('Teacher Dashboard') }}
    @else
        {{ __('Admin Dashboard') }}
    @endauth
@endsection

@section('backend-content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">Nasdec</a>
                            </li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!--Term Setup -->
            <div class="col-xl-6">
                <div class="card border border-primary">
                    <div class="card-body">

                        <h4 class="card-title text-secondary mb-4">Current Term => <span class="text-dark"
                                style="letter-spacing: 0.05em; font-size: 18px;">{{ $config->term->name }}</span>
                        </h4>
                        <form class="row g-2 align-items-center" method="POST"
                            action="{{ route('management.update.term') }}">
                            @csrf

                            <div class="col-12 col-sm-9">
                                <div class="input-group mb-2 mb-sm-0">
                                    <span class="input-group-text">Change Current Term</span>
                                    <select class="form-select" id="current_term" name="current_term">
                                        <option selected disabled>Choose ...</option>
                                        @foreach ($terms as $term)
                                            <option value="{{ $term->id }}">{{ $term->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <button type="submit" class="btn btn-warning w-100"
                                    onclick="this.disabled=true; this.form.submit(); this.innerText='Updating...';">
                                    Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->

            <!--Assessment Setup -->
            <div class="col-xl-6">
                <div class="card border border-primary">
                    <div class="card-body">
                        <h4 class="card-title text-secondary mb-4">Current Assessment Type => <span class="text-dark"
                                style=" font-size: 16px; ">{{ $config->exam->title }}</span>
                        </h4>
                        <form class="row g-2 align-items-center" method="POST"
                            action="{{ route('management.update.assessment_type') }}">
                            @csrf

                            <div class="col-12 col-sm-9">
                                <div class="input-group mb-2 mb-sm-0">
                                    <span class="input-group-text">Set Current Assessment</span>
                                    <select class="form-select" id="exam_type" name="exam_type">
                                        <option selected disabled>Choose ...</option>
                                        @foreach ($exam_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="this.disabled=true; this.form.submit(); this.innerText='Submitting...';">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->

            <!--Session Setup -->
            <div class="col-xl-6">
                <div class="card border border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <h4 class="card-title text-secondary ">Current Session => <span class="text-dark"
                                    style=" font-size: 16px; font-family: 'Courier New', Courier, monospace; font-weight: bolder;">
                                    {{ $config->year->name }} </span>
                            </h4>
                            <button class="btn btn-info btn-sm d-flex align-items-center waves-effect waves-light add-btn"
                                data-bs-toggle="modal" data-bs-target=".add-session">
                                <i class="ri-add-fill font-size-13"></i>
                                <span style="margin-left: 5px;">Add Session</span>
                            </button>
                        </div>
                        <form class="row g-2 align-items-center" method="POST"
                            action="{{ route('management.update.current_session') }}">
                            @csrf

                            <div class="col-12 col-sm-9">
                                <div class="input-group mb-2 mb-sm-0">
                                    <span class="input-group-text">Change Current Session</span>
                                    <select class="form-select" id="session" name="current_session">
                                        <option selected disabled>Choose ...</option>
                                        @foreach ($sessions as $session)
                                            <option value="{{ $session->id }}">{{ $session->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <button type="submit" class="btn btn-primary w-100"
                                    onclick="this.disabled=true; this.form.submit(); this.innerText='Submitting...';">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>

    <!-- Add Session Modal -->
    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="modal fade add-session" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Session</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="" class="row g-2 align-items-center" method="POST"
                            action="{{ route('management.add.academic_year') }}">
                            @csrf

                            <input type="hidden" id="classInput" name="id">

                            <div class="col-12 col-sm-9">
                                <input id="" type="text" name="year" class="form-control"
                                    placeholder="e.g 2017/2016" required>
                            </div>
                            <div class="col-12 col-sm-3">
                                <button type="submit" class="btn btn-dark w-100">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
@endsection
