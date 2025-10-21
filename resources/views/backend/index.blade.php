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
                    <div class="d-flex flex-column">
                        <h4 class="mb-sm-0">Dashboard</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('management.dashboard') }}">Nasdec</a>
                                </li>
                                <li class="breadcrumb-item active">dashboard</li>
                            </ol>
                        </div>
                    </div>
                    <div class="card d-flex flex-row gap-3 p-2" style="background-color: #DCDCDC">
                        <div class="d-flex flex-column">
                            <span class="fw-bold"
                                style="color: #0000A3; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">Current
                                Year</span>
                            <span class="fw-bold"
                                style="color: #494949; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
                                {{ $config->year->name }}
                            </span>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-bold"
                                style="color: #0000A3; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
                                Current Term
                            </span>
                            <span class="fw-bold"
                                style="color: #494949; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif">
                                {{ $config->term->name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            @auth('admin')
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">
                                        Total Student
                                    </p>
                                    <h4 class="mb-2">{{ $students }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="fas fa-users font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end cardbody -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">
                                        Total Teachers
                                    </p>
                                    <h4 class="mb-2">{{ $teachers }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-success rounded-3">
                                        <i class="fas fa-users-cog font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end cardbody -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            @endauth

            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">
                                    Total Subject
                                </p>
                                <h4 class="mb-2">{{ $uniqueSubjects }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="fas fa-file-alt font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
            <div class="col-xl-3 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Questions</p>
                                <h4 class="mb-2">{{ $questions }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="fas fa-question-circle font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

            @auth('teacher')
                <div class="col-xl-3 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="text-truncate font-size-14 mb-2">Total Class</p>
                                    <h4 class="mb-2">{{ $classes }}</h4>
                                </div>
                                <div class="avatar-sm">
                                    <span class="avatar-title bg-light text-primary rounded-3">
                                        <i class="far fa-building font-size-24"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- end cardbody -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            @endauth

        </div>
        <!-- end row -->

    </div>
@endsection
