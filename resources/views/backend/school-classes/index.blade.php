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

                    <x-flash-message type="info" />

                    <x-table :columns="['S/N', 'Classname', 'Action']">
                        @foreach ($classes as $key => $class)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $class->name }}</td>
                                <td>
                                    <button href="" class="btn btn-primary btn-sm waves-effect waves-light edit-btn"
                                        data-id="{{ $class->id }}" data-name="{{ $class->name }}" data-bs-toggle="modal"
                                        data-bs-target=".edit-class-modal">Edit</button>
                                    <a href="" class="btn btn-danger btn-sm" id="delete" title="Delete">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Class</h4>
                    <form class="row g-2 align-items-center" method="POST" action="{{ route('management.add.class') }}">
                        @csrf

                        <x-flash-message type="success" />
                        <x-flash-message type="error" />

                        <div class="col-12 col-sm-9">
                            <input type="text" class="form-control" name="school_class" placeholder="Enter class...">
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
        <div class="modal fade edit-class-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editClassForm" class="row g-2 align-items-center" method="POST"
                            action="{{ route('management.update.class') }}">
                            @csrf
                            @method('PUT')

                            <input type="hidden" id="classInput" name="id">

                            <div class="col-12 col-sm-9">
                                <input id="classNameInput" type="text" name="school_class" class="form-control"
                                    placeholder="Enter class..." required>
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
        <!-- /.modal -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-btn');
            const classNameInput = document.getElementById('classNameInput');
            const classInput = document.getElementById('classInput');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    classNameInput.value = this.dataset.name;
                    classInput.value = this.dataset.id;
                });
            });
        })
    </script>
@endsection
