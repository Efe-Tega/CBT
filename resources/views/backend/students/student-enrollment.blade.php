@extends('backend.backend-main')

@section('title')
    {{ __('Student Registration') }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-item-center justify-content-between">
                <h4 class="mb-sm-0">Student Enrollment</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">student registration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-7 order-sm-1 order-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Register Student</h4>
                    <p class="card-title-desc">Label input field with <code>*</code> are required.
                    </p>

                    <x-flash-message type="info" />

                    <form class="needs-validation" novalidate method="POST"
                        action="{{ route('management.register.student') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Surname *</label>
                                    <input type="text" class="form-control" id="" name="lastname"
                                        value="{{ old('lastname') }}" placeholder="Enter surname" required>

                                    @error('lastname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">First name *</label>
                                    <input type="text" class="form-control" id="" name="firstname"
                                        value="{{ old('firstname') }}" placeholder="Enter first name" required>

                                    @error('firstname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Middle name</label>
                                    <input type="text" class="form-control" id="" name="middlename"
                                        value="{{ old('middlename') }}" placeholder="Enter middle name">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">School *</label>
                                    <select class="form-select" id="" name="school_id" required>
                                        <option selected disabled value="">Choose...</option>
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('school_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom03" class="form-label">Class *</label>
                                    <select class="form-select" id="validationCustom03" name="school_class" required>
                                        <option selected disabled value="">Choose...</option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('school_class')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Gender</label>
                                    <select class="form-select" id="" name="gender">
                                        <option selected disabled value="">Choose...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>

                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary"
                                onclick="this.disabled=true; this.form.submit(); this.innerText='Registering...';"
                                type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-5 order-sm-2 order-1">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Find Students</h4>

                    <form class="row g-2 align-items-center" action="{{ route('management.find.student') }}"
                        method="POST">
                        @csrf

                        <div class="col-12 col-sm-9">
                            <div class="input-group mb-2 mb-sm-0">
                                <span class="input-group-text">Class</span>

                                <select
                                    class="form-select @error('class_id') is-invalid
                                @enderror"
                                    name="class_id" required>

                                    <option selected disabled>Choose...</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="col-12 col-sm-3">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end card -->

    </div>
@endsection
