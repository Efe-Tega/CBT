@extends('backend.backend-main')

@section('title')
    {{ $subject->class->name }} {{ $subject->name }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <div class="d-flex flex-column">
                    <h4 class="mb-sm-0">{{ $subject->name }} - {{ $subject->class->name }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('management.questions') }}">Questions</a>
                            </li>
                            <li class="breadcrumb-item active">{{ strtolower($subject->name) }}</li>
                        </ol>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm d-flex align-items-center waves-effect waves-light add-btn"
                        data-bs-toggle="modal" data-bs-target=".add-question-modal">
                        <i class="ri-add-fill font-size-20"></i>
                        <span style="margin-left: 5px; font-size: 16px; font-weight: bold;">Add Question</span>
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

                    <h4 class="card-title">List</h4>
                    <x-table :columns="['S/N', 'Question', 'Actions']">
                        @foreach ($questions as $key => $question)
                            <tr id="">
                                <td>{{ $key + 1 }}</td>
                                <td>{!! Str::limit($question->question_text, 80) !!}</td>

                                <td>
                                    <button href="" class="btn btn-primary btn-sm waves-effect waves-light edit-btn"
                                        data-bs-toggle="modal" data-bs-target=".edit-student-modal"> View </button>

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
        <div class="modal fade add-question-modal" id="addQuestionModal" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addQuestionForm" class="row g-2 align-items-center">
                            @csrf

                            <input type="hidden" id="" name="subject_id" value="{{ $subject->id }}">
                            <input type="hidden" id="" name="exam_id" value="{{ $exam->id }}">

                            <div class="row">
                                <div class="col-12 mb-4">
                                    <h4 class="card-title">Question</h4>
                                    <textarea id="elm1" name="question_text"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Option A</label>
                                        <textarea class="form-control" name="option_a" id=""></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Option B</label>
                                        <textarea class="form-control" name="option_b" id=""></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Option C</label>
                                        <textarea class="form-control" name="option_c" id=""></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Option D</label>
                                        <textarea class="form-control" name="option_d" id=""></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Correct Answer</label>
                                        <select class="form-select" id="" name="correct_answer" required>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-8 mx-auto">
                                <button id="saveBtn" type="submit" class="btn btn-primary w-100">Submit
                                    Question</button>
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
            const form = document.getElementById('addQuestionForm');
            const saveBtn = document.getElementById('saveBtn');
            const modal = new bootstrap.Modal(document.getElementById('addQuestionModal'));

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                saveBtn.disabled = true;
                saveBtn.textContent = 'Submitting...';

                const formData = new FormData(form);

                try {
                    const response = await fetch("{{ route('management.store.question') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok) {
                        toastr.success(data.message, 'Success');
                        form.reset();
                        modal.hide();
                    } else if (data.errors) {
                        let message = '';
                        for (let key in data.errors) {
                            message += data.errors[key][0] + '\n';
                        }
                        toastr.error(message, 'Validation Error');
                    }
                } catch (error) {
                    toastr.error('Something went wrong!', 'Error');
                } finally {
                    saveBtn.disabled = false;
                    saveBtn.textContent = 'Submit Question';
                }
            });
        });
    </script>
@endsection
