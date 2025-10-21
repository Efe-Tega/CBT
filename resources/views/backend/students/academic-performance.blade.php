@extends('backend.backend-main')

@section('title')
    {{ __('Students Score Sheet') }}
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

                    <form class="row g-2 align-items-center" action="{{ route('management.get_scoresheet') }}"
                        method="POST">
                        @csrf

                        <div class="col-12 col-sm-5">
                            <div class="input-group mb-2 mb-sm-0">
                                <span class="input-group-text">Class</span>
                                <select class="form-select" id="class_id" name="class_id">
                                    <option selected disabled>Select class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-sm-5">
                            <div class="input-group mb-2 mb-sm-0">
                                <span class="input-group-text">Subjects</span>
                                <select class="form-select" id="subject_id" name="subject_id">
                                    <option selected disabled>Choose ...</option>
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

    @if ($classId && $students->isNotEmpty() && $subjects->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Score sheet</h4>
                        @if ($classId && $students->isNotEmpty() && $subjects->isNotEmpty())
                            <x-responsive-table :columns="array_merge(['S/N', 'Student Name'], $subjects->pluck('name')->toArray(), [
                                'Total',
                                'Action',
                            ])">
                                @foreach ($students as $index => $student)
                                    @php
                                        $studentTotalCorrect = 0;
                                        $studentTotalPossible = 0;
                                    @endphp


                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->lastname }}</td>
                                        @foreach ($subjects as $subject)
                                            @php
                                                $subjectScore =
                                                    $scores[$student->id][$subject->id]['total_correct'] ?? 0;
                                                $subjectTotal = $totalQuestions[$subject->id] ?? 0;
                                                $studentTotalCorrect += $subjectScore;
                                                $studentTotalPossible += $subjectTotal;
                                            @endphp

                                            <td>{{ $subjectScore }} / {{ $subjectTotal }}</td>
                                        @endforeach
                                        <td>{{ $studentTotalCorrect }}/ {{ $studentTotalPossible }}</td>
                                        <td>
                                            <a href="" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach

                            </x-responsive-table>
                        @else
                            <div class="alert alert-warning mt-4">
                                No results found for this class.
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- end row -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('class_id');
            const subjectSelect = document.getElementById('subject_id');

            function resetSubjects() {
                subjectSelect.innerHTML = '<option selected disabled>Choose subject ...</option>';
            }

            resetSubjects();

            classSelect.addEventListener('change', function() {
                const classId = this.value;

                if (!classId) {
                    resetSubjects();
                    return;
                }

                fetch(`/management/get_subjects/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        resetSubjects();

                        if (data.length > 0) {
                            data.forEach(subject => {
                                const option = document.createElement('option');
                                option.value = subject.id;
                                option.textContent = subject.name;
                                subjectSelect.appendChild(option);
                            });
                        } else {
                            const option = document.createElement('option');
                            option.disabled = true;
                            option.textContent = 'No subjects available for this class';
                            subjectSelect.appendChild(option);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching subjects:', error);
                        resetSubjects();
                    });
            });
        });
    </script>
@endsection
