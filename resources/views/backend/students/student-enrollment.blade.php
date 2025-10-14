@extends('backend.backend-main')
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

                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom01" class="form-label">First name</label>
                                    <input type="text" class="form-control" id="validationCustom01"
                                        placeholder="Enter first name" required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom02" class="form-label">Middle name</label>
                                    <input type="text" class="form-control" id="validationCustom02"
                                        placeholder="Enter middle name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom04" class="form-label">Surname</label>
                                    <input type="text" class="form-control" id="validationCustom04"
                                        placeholder="Enter surname" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="validationCustom03" class="form-label">Gender</label>
                                    <select class="form-select" id="validationCustom03" required>
                                        <option selected disabled value="">Choose...</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary" type="submit">Submit form</button>
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

                    <form class="row g-2 align-items-center">

                        <div class="col-12 col-sm-9">
                            <div class="input-group mb-2 mb-sm-0">
                                <span class="input-group-text">Class</span>
                                <select class="form-select">
                                    <option selected disabled>Choose...</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
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
