@extends('backend.backend-main')
@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Questions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">questions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">All Subjects</h4>

                    <x-table :columns="['S/N', 'Subject', 'Class', 'Action']">
                        <tr>
                            <td>1</td>
                            <td>Mathematics</td>
                            <td>JSS 1</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>English Language</td>
                            <td>JSS 1</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Civic Education</td>
                            <td>JSS 1</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Computer Science</td>
                            <td>JSS 1</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    </x-table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
