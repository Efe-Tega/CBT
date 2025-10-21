@extends('backend.backend-main')

@section('title')
    {{ __('Teacher Registration') }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-item-center justify-content-between">
                <h4 class="mb-sm-0">Teacher Registration</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">teacher registration</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-4 order-md-2">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Register Teacher</h4>
                    <p class="card-title-desc">Input field with <code>*</code> are required.
                    </p>

                    <x-flash-message type="success" />

                    <form class="needs-validation" novalidate method="POST"
                        action="{{ route('management.register.teacher') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Surname *</label>
                                    <input type="text" class="form-control" id="" name="surname"
                                        value="{{ old('surname') }}" placeholder="Enter surname" required>

                                    @error('surname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Othernames *</label>
                                    <input type="text" class="form-control" id="" name="othernames"
                                        value="{{ old('othernames') }}" placeholder="Enter othernames" required>

                                    @error('othernames')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control" id="" name="email"
                                        value="{{ old('email') }}" placeholder="Enter email address" required>

                                    @error('email')
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

        <div class="col-md-8 order-md-1">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title"> All Teachers</h4>
                    <p class="text-danger"><strong class="text-secondary">NOTE:</strong> Blocked teachers won't be able to
                        login</p>
                    <x-table :columns="['S/N', 'Name', 'Status', 'Date Created', 'Actions']">
                        @foreach ($teachers as $key => $teacher)
                            @php
                                $fullName = $teacher->name;
                                $nameParts = explode(' ', trim($fullName));
                                $firstName = $nameParts[0];
                                $otherNames = implode(' ', array_slice($nameParts, 1));
                            @endphp

                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td>

                                    <div class="">
                                        <input type="checkbox" id="teacher-switch-{{ $teacher->id }}" switch="bool"
                                            class="toggle-status" data-id="{{ $teacher->id }}"
                                            {{ $teacher->status === 'active' ? 'checked' : '' }} />
                                        <label for="teacher-switch-{{ $teacher->id }}" data-on-label="Active"
                                            data-off-label="Blocked"></label>
                                    </div>
                                </td>
                                <td>{{ $teacher->created_at->diffForHumans() }}</td>
                                <td>
                                    <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $teacher->id }}"
                                        data-name="{{ $firstName }}" data-othername="{{ $otherNames }}"
                                        data-email="{{ $teacher->email }}" data-bs-toggle="modal"
                                        data-bs-target="#editTeacherModal">Edit</button>
                                    <a href="{{ route('management.delete.teacher_data', $teacher->id) }}"
                                        class="btn btn-danger btn-sm" id="delete">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
        <!-- end card -->

    </div>

    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="modal fade" id="editTeacherModal" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Update Teacher Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" novalidate method="POST"
                            action="{{ route('management.update.teacher_data') }}">
                            @csrf

                            <input type="hidden" name="id" id="teacher_id">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Surname *</label>
                                        <input type="text" class="form-control" id="surname" name="surname"
                                            placeholder="Enter surname" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Othernames *</label>
                                        <input type="text" class="form-control" id="othername" name="othernames"
                                            placeholder="Enter othernames" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Email Address *</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Enter email address" required>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-primary" type="submit"> Update </button>
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
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.toggle-status').forEach(toggle => {
                toggle.addEventListener('change', async function() {
                    const id = this.dataset.id;

                    try {
                        const response = await fetch(`/management/teachers/${id}/toggle`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                        });

                        const data = await response.json();

                        if (data.success) {
                            console.log(`Teacher ${id} set to ${data.status}`);
                        } else {
                            alert('Failed to update status');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('An error occured.')
                    }
                })
            })
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-btn')) {
                    const btn = e.target;

                    const id = e.target.getAttribute('data-id');
                    const teacherName = e.target.getAttribute('data-name');
                    const otherNames = btn.getAttribute('data-othername');
                    const emailAddress = btn.getAttribute('data-email');

                    document.getElementById('teacher_id').value = id;
                    document.getElementById('surname').value = teacherName
                    document.getElementById('othername').value = otherNames
                    document.getElementById('email').value = emailAddress
                }
            })
        })
    </script>
@endsection
