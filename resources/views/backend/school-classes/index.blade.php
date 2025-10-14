@extends('backend.backend-main')

@section('title')
    {{ __('Classes') }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-item-center justify-content-between">
                <h4 class="mb-sm-0">Classes</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">classes</li>
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

                    <h4 class="card-title">All Classes</h4>

                    <x-table :columns="['S/N', 'Classname', 'Action']">
                        <tr>
                            <td>1</td>
                            <td>JSS 1</td>
                            <td>
                                <button href="" class="btn btn-primary btn-sm waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Edit</button>
                                <a href="" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>JSS 1</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">Edit</a>
                                <a href="" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>JSS 1</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">Edit</a>
                                <a href="" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>JSS 1</td>
                            <td>
                                <a href="" class="btn btn-primary btn-sm">Edit</a>
                                <a href="" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                    </x-table>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Class</h4>
                    <form class="row g-2 align-items-center">
                        <div class="col-12 col-sm-9">
                            <input type="text" class="form-control" placeholder="Enter text...">
                        </div>
                        <div class="col-12 col-sm-3">
                            <button type="submit" class="btn btn-primary w-100">Add Class</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-2 align-items-center">
                            <div class="col-12 col-sm-9">
                                <input type="text" class="form-control" placeholder="Enter text...">
                            </div>
                            <div class="col-12 col-sm-3">
                                <button type="submit" class="btn btn-info w-100">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->`
    </div>
@endsection
