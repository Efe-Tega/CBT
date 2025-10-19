@extends('backend.backend-main')

@section('title')
    {{ $class->name }} Students
@endsection
@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="d-flex flex-column">
                    <h4 class="mb-sm-0">All {{ $class->name }} Students</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="javascript: void(0);">nasdec</a>
                            </li>
                            <li class="breadcrumb-item ">students</li>
                            <li class="breadcrumb-item active">{{ strtolower($class->name) }}</li>

                        </ol>
                    </div>
                </div>
                <div>

                    <button onclick="window.history.back()" class="btn btn-primary btn-sm d-flex align-items-center">
                        <i class="ri-rewind-mini-fill font-size-20"></i>
                        <span style="margin-left: 5px">Back</span>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">{{ $class->name }} Class List</h4>
                    <x-table :columns="['S/N', 'Registration No.', 'Surname', 'Other Names', 'Gender', 'Actions']">
                        @foreach ($students as $key => $student)
                            <tr id="student-row-{{ $student->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $student->registration_number }}</td>
                                <td>{{ $student->lastname }}</td>
                                <td>{{ $student->middlename }} {{ $student->firstname }}</td>
                                <td>{{ Str::title(strtolower($student->gender)) }}</td>
                                <td>
                                    <button href="" class="btn btn-primary btn-sm waves-effect waves-light edit-btn"
                                        data-id="{{ $student->id }}" data-school_id = "{{ $student->school_id }}"
                                        data-firstname="{{ $student->firstname }}"
                                        data-middlename="{{ $student->middlename }}"
                                        data-lastname="{{ $student->lastname }}" data-gender="{{ $student->gender }}"
                                        data-class="{{ $student->class_id }}" data-bs-toggle="modal"
                                        data-bs-target=".edit-student-modal"> Edit </button>
                                    <a href="{{ route('management.delete.student_data', $student->id) }}"
                                        class="btn btn-danger btn-sm delete-btn">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="modal fade edit-student-modal" id="editStudentModal" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editStudentForm" class="row g-2 align-items-center">
                            @csrf

                            <input type="hidden" id="studentId" name="id">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Surname *</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname"
                                            placeholder="Enter surname" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">First name *</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname"
                                            placeholder="Enter first name" value="" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Middle name</label>
                                        <input type="text" class="form-control" id="middlename" name="middlename"
                                            placeholder="Enter middle name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">School *</label>
                                        <select class="form-select" id="school_id" name="school_id" required>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Class *</label>
                                        <select class="form-select" id="school_class" name="school_class" required>
                                            @foreach ($classLevels as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Gender</label>
                                        <select class="form-select" id="gender" name="gender">
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
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

    <!-- Modal update script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('editStudentForm');
            const editModal = document.getElementById('editStudentModal');

            // Listen for Bootstrap modal show event
            editModal.addEventListener('show.bs.modal', function(event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract data attributes from button
                const id = button.getAttribute('data-id');
                const schoolId = button.getAttribute('data-school_id');
                const firstname = button.getAttribute('data-firstname');
                const middlename = button.getAttribute('data-middlename');
                const lastname = button.getAttribute('data-lastname');
                const gender = button.getAttribute('data-gender');
                const schoolClass = button.getAttribute('data-class');

                // Populate modal fields safely
                editModal.querySelector('#studentId').value = id;
                editModal.querySelector('#school_id').value = schoolId;
                editModal.querySelector('#firstname').value = firstname || '';
                editModal.querySelector('#middlename').value = middlename || '';
                editModal.querySelector('#lastname').value = lastname || '';
                editModal.querySelector('#gender').value = gender || 'Male';
                editModal.querySelector('#school_class').value = schoolClass;
            });

            // Handle AJAX form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                const formData = new FormData(form);
                const id = formData.get('id');

                try {
                    const response = await fetch(`{{ route('management.update.student_data') }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();
                    if (response.ok) {
                        // Update table row dynamically
                        const row = document.getElementById(`student-row-${id}`);
                        row.children[2].textContent = data.student.lastname;
                        row.children[3].textContent =
                            `${data.student.middlename} ${data.student.firstname}`;
                        row.children[4].textContent = data.student.gender;

                        // Hide modal
                        const modal = bootstrap.Modal.getInstance(document.querySelector(
                            '.edit-student-modal'));
                        modal.hide();

                        alert('Student data updated');
                    } else {
                        alert(data.message || 'Update failed.')
                    }
                } catch (err) {
                    console.error(err);
                    alert('Something went wrong');
                }
            });

        });
    </script>

    <!-- Delete Student Data script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $(document).on("click", ".delete-btn", function(e) {
                e.preventDefault();

                var button = $(this);
                var link = button.attr("href");
                var row = button.closest("tr");

                Swal.fire({
                    title: "Are you sure?",
                    text: "This action cannot be undone!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: link,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.success) {
                                    row.fadeOut(400, function() {
                                        $(this).remove();
                                    });

                                    Swal.fire("Delete!",
                                        "Student deleted successfully.", "success");
                                } else {
                                    toastr.error(response.message ||
                                        "Failed to delete student.");
                                }
                            },
                            error: function() {
                                toastr.error("Something went wrong. Please try again.");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
