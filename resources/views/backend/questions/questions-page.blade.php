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
                    <x-table :columns="['S/N', 'Question', 'Status', 'Actions']">
                        @foreach ($questions as $key => $question)
                            <tr data-id="{{ $question->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>{!! Str::limit($question->question_text, 80) !!}</td>
                                <td>
                                    <div class="square-switch">
                                        <input type="checkbox" id="question-switch-{{ $question->id }}" switch="bool"
                                            class="toggle-status" data-id="{{ $question->id }}"
                                            {{ $question->is_visible === 1 ? 'checked' : '' }} />
                                        <label for="question-switch-{{ $question->id }}" data-on-label="Published"
                                            data-off-label="Not visible"></label>
                                    </div>
                                </td>

                                <td>
                                    <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $question->id }}"
                                        data-instruction_id="{{ $question->instruction_id ?? '' }}"
                                        data-instruction_text="{{ $question->instruction?->text ?? '' }}"
                                        data-question="{!! e($question->question_text) !!}"
                                        data-option_a="{{ e($question->option_a) }}"
                                        data-option_b="{{ e($question->option_b) }}"
                                        data-option_c="{{ e($question->option_c) }}"
                                        data-option_d="{{ e($question->option_d) }}"
                                        data-correct_answer = "{{ e($question->correct_answer) }}" data-bs-toggle="modal"
                                        data-bs-target="#addQuestionModal">Edit</button>

                                    <button href="" class="btn btn-info btn-sm waves-effect waves-light view-btn"
                                        data-question_text="{{ $question->question_text }}"
                                        data-option_a="{{ $question->option_a }}"
                                        data-option_b="{{ $question->option_b }}"
                                        data-option_c="{{ $question->option_c }}"
                                        data-option_d="{{ $question->option_d }}"
                                        data-correct_answer = "{{ $question->correct_answer }}" data-bs-toggle="modal"
                                        data-bs-target=".view-question"> View </button>

                                    <a href="{{ route('management.delete.question', $question->id) }}"
                                        class="btn btn-danger btn-sm" id="delete">Delete</a>

                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add/Edit Form Modal --}}
    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="modal fade add-question-modal" id="addQuestionModal" tabindex="-1" role="dialog"
            aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Question</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addQuestionForm" class="row g-2 align-items-center">
                            @csrf

                            <input type="hidden" name="id" id="question_id">
                            <input type="hidden" id="" name="subject_id" value="{{ $subject->id }}">

                            {{-- Choose existing or add new instruction --}}
                            <div class="row">
                                <div class="mb-3">
                                    <label for="instruction_id" class="form-label">Instruction (optional)</label>
                                    <select name="instruction_id" id="instruction_id" class="form-control">
                                        <option value="">-- Select existing instruction --</option>
                                        @foreach ($instructions as $instruction)
                                            <option value="{{ $instruction->id }}">
                                                {{ Str::limit($instruction->text, 80) }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="mt-2 text-center text-muted">or</div>

                                    <textarea name="instruction_text" id="instruction" class="form-control mt-2"
                                        placeholder="Enter new instruction (leave blank if using existing one)"></textarea>
                                </div>
                            </div>

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
                                        <textarea class="form-control" name="option_a" id="option_a"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Option B</label>
                                        <textarea class="form-control" name="option_b" id="option_b"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Option C</label>
                                        <textarea class="form-control" name="option_c" id="option_c"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Option D</label>
                                        <textarea class="form-control" name="option_d" id="option_d"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Correct Answer</label>
                                        <select class="form-select" id="correct_answer" name="correct_answer" required>
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

    {{-- View Question Modal --}}
    <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="modal fade view-question" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Question Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Question</h6>
                        <div class="" id="question_text"></div>

                        <h6 class="mt-5">Options</h6>
                        <hr>
                        <div class="d-flex gap-5">
                            <span>Option A</span>
                            <span class="text-dark" id="firstOption"></span>
                        </div>
                        <hr>
                        <div class="d-flex gap-5">
                            <span>Option B</span>
                            <span class="text-dark" id="secondOption"></span>
                        </div>
                        <hr>
                        <div class="d-flex gap-5">
                            <span>Option C</span>
                            <span class="text-dark" id="thirdOption"></span>
                        </div>
                        <hr>
                        <div class="d-flex gap-5">
                            <span>Option D</span>
                            <span class="text-dark" id="fourthOption"></span>
                        </div>

                        <h6 class="mt-5">Correct Answer</h6>
                        <span class="text-success" id="correctAnswerOption"></span>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>

    <!-- View modal script-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const viewButtons = document.querySelectorAll('.view-btn');

            function stripHTML(html) {
                let tempDiv = document.createElement("div");
                tempDiv.innerHTML = html;
                return tempDiv.textContent || tempDiv.innerText || "";
            }

            function showValueOrDefault(elementId, value) {
                const el = document.getElementById(elementId);
                const cleanValue = value ?? ''

                if (!cleanValue) {
                    el.innerHTML = '<em>No option</em>';
                } else {
                    el.textContent = cleanValue;
                }
            }

            viewButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const question = this.getAttribute('data-question_text');
                    const optionA = this.getAttribute('data-option_a');
                    const optionB = this.getAttribute('data-option_b');
                    const optionC = this.getAttribute('data-option_c');
                    const optionD = this.getAttribute('data-option_d');
                    const correctAnswer = this.getAttribute('data-correct_answer');

                    document.getElementById('question_text').textContent = stripHTML(question);
                    document.getElementById('firstOption').textContent = optionA;
                    document.getElementById('secondOption').textContent = optionB;
                    document.getElementById('thirdOption').textContent = optionC;
                    showValueOrDefault('fourthOption', optionD);
                    document.getElementById('correctAnswerOption').textContent =
                        `Option ${correctAnswer}`;
                });
            });
        });
    </script>


    <!-- Add/Edit modal script-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('addQuestionForm');
            const saveBtn = document.getElementById('saveBtn');
            const modal = new bootstrap.Modal(document.getElementById('addQuestionModal'));
            const modalTitle = document.getElementById('modalTitle');
            const tableBody = document.querySelector('#datatable tbody');
            let editMode = false

            // Edit button click
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('edit-btn')) {
                    editMode = true;
                    const btn = e.target;

                    const id = e.target.getAttribute('data-id');
                    const questionText = e.target.getAttribute('data-question');

                    document.getElementById('question_id').value = id;
                    document.getElementById('instruction_id').value = btn.dataset.instruction_id || '';
                    document.getElementById('option_a').value = btn.dataset.option_a || '';
                    document.getElementById('option_b').value = btn.dataset.option_b || '';
                    document.getElementById('option_c').value = btn.dataset.option_c || '';
                    document.getElementById('option_d').value = btn.dataset.option_d || '';
                    document.getElementById('correct_answer').value = btn.dataset.correct_answer || '';

                    document.getElementById('instruction').value = btn.dataset.instruction_text || '';

                    modalTitle.textContent = 'Edit Question';
                    saveBtn.textContent = 'Update Question';

                    if (tinymce.get('elm1')) {
                        tinymce.get('elm1').setContent(questionText);
                    }
                }
            })

            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                // Fix TinyMCE value not syncing
                if (typeof tinymce !== 'undefined') {
                    tinymce.triggerSave();
                }

                saveBtn.disabled = true;
                saveBtn.textContent = editMode ? 'Updating...' : 'Submitting...';

                const formData = new FormData(form);
                const questionId = document.getElementById('question_id').value;
                const url = editMode ? `/management/questions/update/${questionId}` :
                    `{{ route('management.store.question') }}`;

                try {
                    const response = await fetch(url, {
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

                        if (editMode) {
                            const row = tableBody.querySelector(`tr[data-id="${questionId}"]`);

                            const questionText = data?.data?.question_text;

                            // If question_text is null, show a friendly placeholder
                            row.children[1].innerHTML = questionText ?
                                questionText.substring(0, 80) + (questionText.length > 80 ? '...' :
                                    '') :
                                '<span class="text-muted fst-italic">No question text</span>';
                        } else {

                            const newRow = document.createElement('tr');
                            const sn = tableBody.rows.length + 1;

                            newRow.innerHTML = `
                        <td>${sn}</td>
                        <td>${data.data.question_text.substring(0,80)}${data.data.question_text.length > 80 ? '...' : ''}</td>
                        <td>
                            <button class="btn btn-info btn-sm edit-btn" 
                            data-id="${data.data.id}"
                            data-instruction_id = "${data.data.instruction_id}"
                            data-question="${data.data.question_text}"
                            data-option_a="${data.data.option_a}"
                            data-option_b="${data.data.option_b}"
                            data-option_c="${data.data.option_c}"
                            data-option_d="${data.data.option_d}"
                            data-correct_answer = "${data.data.correct_answer}"
                            data-bs-toggle="modal" data-bs-target="#addQuestionModal">Edit</button>
                            </td>
                        <td>
                            <button class="btn btn-info btn-sm" 
                            data-bs-toggle="modal" data-bs-target=".edit-student-modal">View</button>
                            </td>
                        `;

                            tableBody.append(newRow);
                        }
                        form.reset();
                        if (tinymce.get('elm1')) tinymce.get('elm1').setContent('');
                        modal.hide();
                        editMode = false;
                        modalTitle.textContent = 'Add Question';
                        saveBtn.textContent = 'Submit Question';

                    } else if (data.errors) {
                        let message = '';
                        for (let key in data.errors) {
                            message += data.errors[key][0] + '\n';
                        }
                        toastr.error(message, 'Validation Error');
                    }
                } catch (error) {
                    console.error("Error details:", error);
                    toastr.error('Something went wrong!', 'Error');
                } finally {
                    saveBtn.disabled = false;
                    saveBtn.textContent = 'Submit Question';
                }
            });
        });
    </script>

    <!-- Toggle question visibility script-->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.toggle-status').forEach(toggle => {
                toggle.addEventListener('change', async function() {
                    const id = this.dataset.id;

                    try {
                        const response = await fetch(`/management/question/${id}/toggle`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                        });

                        const data = await response.json();

                        console.log(data);

                        if (data.success) {
                            console.log(`Subject ${id} set to ${data.status}`);

                        } else {
                            alert('Failed to update status');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('An error occured.');
                    }
                });
            });
        });
    </script>
@endsection
