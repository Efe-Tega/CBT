@extends('backend.backend-main')

@section('title')
    {{ __('Subject Management') }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Subject Management</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">subjects</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Add Subject</h4>
                    <p class="card-title-desc">All fields are required.
                    </p>

                    <x-flash-message type="success" />
                    <x-flash-message type="error" />

                    <form class="needs-validation" novalidate method="POST" action="{{ route('management.add.subject') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Subject Name</label>
                                    <input type="text" class="form-control" id="" name="subject"
                                        value="{{ old('subject') }}" placeholder="Enter subject name" required>

                                    @error('subject')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="validationCustom03" class="form-label">Class</label>
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

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="" class="form-label">School</label>
                                    <select class="form-select" id="" name="school" required>
                                        <option selected disabled value="">Choose...</option>
                                        @foreach ($schools as $school)
                                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('school')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="validationCustom03" class="form-label">Duration</label>
                                    <select class="form-select" id="validationCustom03" name="duration" required>
                                        <option selected disabled value="">Choose...</option>
                                        <option value="30">30 mins</option>
                                        <option value="45">45 mins</option>
                                        <option value="60">60 mins</option>
                                    </select>

                                    @error('duration')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="" class="form-label">Subject question uploader</label>
                                <select class="form-select" id="" name="teacher" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option value="0">Administrator</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>

                                @error('teacher')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <button class="btn btn-primary"
                                onclick="this.disabled=true; this.form.submit(); this.innerText='Submitting...';"
                                type="submit">Register Subject</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->

        @foreach ($subjectsByClass as $subjects)
            <div class="col-xl-6 col-lg-6">
                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title">{{ strtoupper($subjects->first()->class->name) }}</h4>

                        <x-flash-message type="info" />

                        <x-responsive-table :columns="['S/N', 'Subject', 'Duration', 'Action']">
                            @foreach ($subjects as $key => $subject)
                                <tr id="subject-row-{{ $subject->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->duration }} mins</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $subject->id }}"
                                            data-subject="{{ $subject->name }}" data-class_id="{{ $subject->class_id }}"
                                            data-teacher_id="{{ $subject->teacher_id }}"
                                            data-duration="{{ $subject->duration }}"
                                            data-school_id="{{ $subject->school_id }}" data-bs-toggle="modal"
                                            data-bs-target="#updateSubjectModal">Edit</button>
                                    </td>
                                </tr>
                            @endforeach
                        </x-responsive-table>

                    </div>

                </div>
            </div> <!-- end col -->
        @endforeach
    </div> <!-- end row -->

    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="modal fade" id="updateSubjectModal" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" id="editSubjectForm", method="POST"
                            action="{{ route('management.update.school_subject') }}">
                            @csrf

                            <input type="hidden" id="subject_id" name="id">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Subject Name</label>
                                        <input type="text" class="form-control" id="subject" name="subject"
                                            placeholder="Enter subject name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Class</label>
                                        <select class="form-select" id="class_id" name="class_id" required>
                                            <option selected disabled value="">Choose...</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">School</label>
                                        <select class="form-select" id="school_id" name="school_id" required>
                                            <option selected disabled value="">Choose...</option>
                                            @foreach ($schools as $school)
                                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Duration</label>
                                        <select class="form-select" id="duration" name="duration" required>
                                            <option selected disabled value="">Choose...</option>
                                            <option value="30">30 mins</option>
                                            <option value="45">45 mins</option>
                                            <option value="60">60 mins</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="" class="form-label">Subject question uploader</label>
                                    <select class="form-select" id="teacher" name="teacher_id" required>
                                        <option selected disabled value="">Choose...</option>
                                        <option value="0">Administrator</option>
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <button class="btn btn-primary" id="updateBtn" type="submit">Update Subject</button>
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
            const form = document.getElementById("editSubjectForm");
            const editModal = document.getElementById('updateSubjectModal');

            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                const id = button.getAttribute('data-id');
                const subjectName = button.getAttribute('data-subject');
                const teacherId = button.getAttribute('data-teacher_id');
                const classId = button.getAttribute('data-class_id');
                const schoolId = button.getAttribute('data-school_id');
                const duration = button.getAttribute('data-duration');

                editModal.querySelector('#subject_id').value = id;
                editModal.querySelector('#subject').value = subjectName;
                editModal.querySelector('#class_id').value = classId;
                editModal.querySelector('#school_id').value = schoolId;
                editModal.querySelector('#duration').value = duration;
                editModal.querySelector('#teacher').value = teacherId;
            });

        });
    </script>
@endsection
