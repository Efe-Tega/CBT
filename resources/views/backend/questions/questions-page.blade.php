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
                    <a href="{{ route('management.add.questions', $subject->id) }}"
                        class="btn btn-primary btn-sm d-flex align-items-center waves-effect waves-light add-btn">
                        <i class="ri-add-fill font-size-20"></i>
                        <span style="margin-left: 5px; font-size: 16px; font-weight: bold;">Add Question</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">

                    @php
                        $columns = ['', 'S/N', 'Question', 'Marks'];

                        // If admin guard is authenticated, show Status column
                        if (auth()->guard('admin')->check()) {
                            $columns[] = 'Status';
                        }

                        $columns[] = 'Actions';
                    @endphp

                    <h4 class="card-title">List of {{ $subject->name }} Questions</h4>
                    <form id="bulk-delete-form">
                        @csrf

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 mb-3">
                            <button type="button" class="btn btn-secondary btn-sm" id="toggle-select">
                                Select All
                            </button>

                            <button type="submit" class="btn btn-danger btn-sm" id="bulk-delete-btn">
                                Delete Selected
                            </button>
                        </div>

                        <x-table :columns="$columns">
                            @foreach ($questions as $key => $question)
                                <tr data-id="{{ $question->id }}">
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $question->id }}"
                                            class="row-checkbox">
                                    </td>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ Str::limit(strip_tags($question->question_text), 30) }}</td>

                                    <td>{{ $question->marks }}</td>
                                    @if (auth()->guard('admin')->check())
                                        <td>
                                            <div class="square-switch">
                                                <input type="checkbox" id="question-switch-{{ $question->id }}"
                                                    switch="bool" class="toggle-status" data-id="{{ $question->id }}"
                                                    {{ $question->is_visible === 1 ? 'checked' : '' }} />
                                                <label for="question-switch-{{ $question->id }}" data-on-label="Published"
                                                    data-off-label="Not visible"></label>
                                            </div>
                                        </td>
                                    @endif

                                    <td>
                                        <a href="{{ route('management.edit.question', $question->id) }}"
                                            class="btn btn-primary btn-sm edit-btn">Edit</a>

                                        <button type="button" class="btn btn-info btn-sm waves-effect waves-light view-btn"
                                            data-question_text="{{ $question->question_text }}"
                                            data-option_a="{{ $question->option_a }}"
                                            data-option_b="{{ $question->option_b }}"
                                            data-option_c="{{ $question->option_c }}"
                                            data-option_d="{{ $question->option_d }}"
                                            data-option_e="{{ $question->option_e }}"
                                            data-correct_answer = "{{ $question->correct_answer }}" data-bs-toggle="modal"
                                            data-bs-target=".view-question"> View </button>

                                        <a href="{{ route('management.delete.question', $question->id) }}"
                                            class="btn btn-danger btn-sm" id="delete">Delete</a>

                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    </form>
                </div>
            </div>
        </div>
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
                        <hr>
                        <div class="d-flex gap-5">
                            <span>Option E</span>
                            <span class="text-dark" id="fifthOption"></span>
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
                    const optionE = this.getAttribute('data-option_e');
                    const correctAnswer = this.getAttribute('data-correct_answer');

                    document.getElementById('question_text').textContent = stripHTML(question);
                    document.getElementById('firstOption').textContent = optionA;
                    document.getElementById('secondOption').textContent = optionB;
                    showValueOrDefault('thirdOption', optionC);
                    showValueOrDefault('fourthOption', optionD);
                    showValueOrDefault('fifthOption', optionE);
                    document.getElementById('correctAnswerOption').textContent =
                        `Option ${correctAnswer}`;
                });
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

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        const toggleBtn = document.getElementById('toggle-select');
        const bulkDeleteBtn = document.getElementById('bulk-delete-btn');

        function getCheckboxes() {
            return document.querySelectorAll('.row-checkbox');
        }

        function getSelectedIds() {
            return Array.from(getCheckboxes())
                .filter(cb => cb.checked)
                .map(cb => cb.value);
        }

        toggleBtn.addEventListener('click', function() {
            console.log('clicked');
            let checkboxes = getCheckboxes();
            let allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(cb => cb.checked = !allChecked);

            this.textContent = allChecked ? 'Select All' : 'Deselect All';
        });


        // Bulk Delete
        bulkDeleteBtn.addEventListener('click', function() {
            let ids = getSelectedIds();

            if (ids.length === 0) {
                alert('No questions selected');
                return;
            }

            if (!confirm('Delete selected questions?')) return;

            fetch("{{ route('management.bulk.delete') }}", {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        ids
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        ids.forEach(id => {
                            document.querySelector(`tr[data-id="${id}"]`)?.remove();
                        });
                        alert(data.message);
                    }
                })
                .catch(() => alert('Something went wrong'));
        });
    </script>
@endsection
