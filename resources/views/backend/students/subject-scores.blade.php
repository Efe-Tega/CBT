@extends('backend.backend-main')

@section('title', 'Student Subject Scores')

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-item-center justify-content-between">
                <h4 class="mb-sm-0">Subject Scores</h4>

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
                    <h4 class="card-title mb-3">Get Students Subject Scores</h4>

                    <form class="g-2 align-items-center" action="{{ route('management.subject.score') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-sm-0">
                                    <span class="input-group-text">Class</span>
                                    <select class="form-select" id="class_id" name="class_id">
                                        <option selected disabled {{ old('class_id') ? '' : 'selected' }}>Select class
                                        </option>
                                        @foreach ($classes as $class)
                                            <option value="{{ $class->id }}"
                                                {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                                {{ $class->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('class_id')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="input-group mb-sm-0">
                                    <span class="input-group-text">Subject</span>
                                    <select class="form-select" id="subject_id" name="subject_id">
                                        <option selected disabled>Select subject</option>
                                    </select>
                                </div>
                                @error('subject_id')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="input-group mb-sm-0">
                                    <span class="input-group-text">Assessment</span>
                                    <select class="form-select" id="exam_id" name="exam_id">
                                        <option selected disabled>Choose ...</option>
                                        @foreach ($exams as $type)
                                            <option value="{{ $type->id }}"
                                                {{ old('exam_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('exam_id')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="input-group mb-sm-0">
                                    <span class="input-group-text">Term</span>
                                    <select class="form-select" id="term_id" name="term_id">
                                        <option selected disabled>Choose ...</option>
                                        @foreach ($terms as $term)
                                            <option value="{{ $term->id }}"
                                                {{ old('term_id') == $term->id ? 'selected' : '' }}>
                                                {{ $term->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('term_id')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="input-group mb-sm-0">
                                    <span class="input-group-text">Session</span>
                                    <select class="form-select" id="academic_year" name="academic_year">
                                        <option selected disabled>Choose ...</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->id }}"
                                                {{ old('academic_year') == $year->id ? 'selected' : '' }}>
                                                {{ $year->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('academic_year')
                                    <span class="text-danger" role="alert">{{ $message }}</span>
                                @enderror
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

    @if (!$classId)
    @elseif($subjectRecords->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $studentClass = $classes->where('id', $classId)->first();
                            $firstRecord = $subjectRecords->first();
                            $term = $firstRecord->term->name ?? 'N/A';
                            $subject = $firstRecord->subject->name ?? 'N/A';
                            $session = $firstRecord->year->name ?? 'N/A';
                        @endphp

                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">
                                {{ $studentClass->name }} - {{ $subject }} ({{ $firstRecord->exam->title }}) -
                                {{ $term }} Scores - Session {{ $session }}
                            </h4>
                            @if ($classId && $subjectRecords->isNotEmpty())
                                <a href="{{ route('management.export.subject_scores', [
                                    'class_id' => $classId,
                                    'term_id' => $firstRecord->term_id,
                                    'academic_year' => $firstRecord->year_id,
                                    'exam_id' => $firstRecord->exam_id,
                                    'subject_id' => $firstRecord->subject_id,
                                ]) }}"
                                    class="btn btn-success btn-sm">Export to Excel</a>
                            @endif
                        </div>

                        <x-responsive-table :columns="array_merge(['S/N', 'Student Name', 'Registration No', 'Type', 'Score', 'Total'])">

                            @foreach ($subjectRecords as $index => $record)
                                @php
                                    $student = $record->user ?? null;
                                @endphp

                                @if ($student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->lastname }} {{ $student->middlename }} {{ $student->firstname }}
                                        </td>
                                        <td>
                                            {{ $student->registration_number ?? 'N/A' }}
                                        </td>
                                        <td>{{ $record->exam->title }}</td>
                                        <td>{{ $record->correct_answer }} </td>
                                        <td>{{ $record->total_questions }}</td>
                                    </tr>
                                @endif
                            @endforeach

                        </x-responsive-table>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning mt-4">
            No results found
        </div>
    @endif
    <!-- end row -->

    <script>
        document.getElementById('class_id').addEventListener('change', function() {
            let classId = this.value;
            let subjectSelect = document.getElementById('subject_id');

            subjectSelect.innerHTML = '<option value="">Loading...</option>';

            if (!classId) {
                subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                return;
            }

            fetch(`/management/get_subjects/${classId}`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Select Subject </option>';

                    data.forEach(subject => {
                        subjectSelect.innerHTML +=
                            `<option value="${subject.id}">${subject.name}</option>`;
                    });
                })
                .catch(() => {
                    subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
                });
        });
    </script>
@endsection
