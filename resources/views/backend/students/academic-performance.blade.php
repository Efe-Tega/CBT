@extends('backend.backend-main')

@section('title')
    {{ __('Students') }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-item-center justify-content-between">
                <h4 class="mb-sm-0">Academic Performance</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">students</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Get Students Score</h4>

                    <form class="row g-2 align-items-center">
                        <!-- First select with prefix -->
                        <div class="col-12 col-sm-5">
                            <div class="input-group mb-2 mb-sm-0">
                                <span class="input-group-text">Subjects</span>
                                <select class="form-select">
                                    <option selected disabled>Select option 1</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Second select -->
                        <div class="col-12 col-sm-5">
                            <div class="input-group mb-2 mb-sm-0">
                                <span class="input-group-text">Class</span>
                                <select class="form-select">
                                    <option selected disabled>Select option 1</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                </select>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <div class="col-12 col-sm-2">
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- end card -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Score sheet</h4>

                    <x-responsive-table :columns="[
                        'S/N',
                        'Student Name',
                        'English Language',
                        'Mathematics',
                        'French Language',
                        'Igbo Language',
                        'ICT',
                        'CCA',
                        'CRS/IRS',
                        'Home Economics',
                        'Agric. Science',
                        'Civic Education',
                        'Basic Technology',
                        'Basic Science',
                        'Business Studies',
                        'Yoruba Language',
                        'Total',
                        'Action',
                    ]">
                        <tr>
                            <td>1</td>
                            <td>Efakpor oghenetega</td>
                            <td>80</td>
                            <td>60</td>
                            <td>40</td>
                            <td>30</td>
                            <td> 43</td>
                            <td>23</td>
                            <td>1</td>
                            <td>0</td>
                            <td>100</td>
                            <td>
                                <a href="" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    </x-responsive-table>


                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
@endsection
