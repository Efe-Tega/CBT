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
                    <h4 class="card-title mb-3">Get Students Score</h4>

                    <form class="row g-2 align-items-center" action="{{ route('management.performance') }}" method="POST">
                        @csrf

                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-sm-0">
                                <span class="input-group-text">Class</span>
                                <select class="form-select" id="class_id" name="class_id">
                                    <option selected disabled>Select class</option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-sm-0">
                                <span class="input-group-text">Assessment</span>
                                <select class="form-select" id="exam_id" name="exam_id">
                                    <option selected disabled>Choose ...</option>
                                    @foreach ($exams as $type)
                                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-sm-0">
                                <span class="input-group-text">Term</span>
                                <select class="form-select" id="term_id" name="term_id">
                                    <option selected disabled>Choose ...</option>
                                    @foreach ($terms as $term)
                                        <option value="{{ $term->id }}">{{ $term->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <div class="input-group mb-sm-0">
                                <span class="input-group-text">Session</span>
                                <select class="form-select" id="academic_year" name="academic_year">
                                    <option selected disabled>Choose ...</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year->id }}">{{ $year->name }}</option>
                                    @endforeach
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

    @if (!$classId)
    @elseif($records->isNotEmpty())
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        @php
                            $groupedRecords = $records->groupBy('user_id');
                            $studentClass = $classes->where('id', $classId)->first();
                            $firstRecord = $records->first();
                            $term = $firstRecord->term->name ?? 'N/A';
                            $session = $firstRecord->year->name ?? 'N/A';
                        @endphp

                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">
                                {{ $examInfo->exam->title }} Score Sheet for {{ $studentClass->name }} -
                                {{ $term }}
                                - Session {{ $session }}
                            </h4>
                            @if ($classId && $records->isNotEmpty())
                                <a href="{{ route('management.students.export', [
                                    'class_id' => $classId,
                                    'term_id' => $firstRecord->term_id,
                                    'academic_year' => $firstRecord->year_id,
                                    'exam_id' => $firstRecord->exam_id,
                                ]) }}"
                                    class="btn btn-success btn-sm">Export to Excel</a>
                            @endif
                        </div>

                        <x-responsive-table :columns="array_merge(['S/N', 'Student Name'], $subjects->pluck('name')->toArray(), ['Total'])">
                            @foreach ($groupedRecords as $index => $studentRecords)
                                @php
                                    $student = $studentRecords->first()->user ?? null;
                                    $studentTotalCorrect = 0;
                                    $studentTotalQuestions = 0;
                                @endphp

                                @if ($student)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $student->lastname }} {{ $student->middlename }} {{ $student->firstname }}
                                        </td>
                                        @foreach ($subjects as $subject)
                                            @php
                                                $record = $studentRecords->where('subject_id', $subject->id)->first();
                                                $correct = $record->correct_answer ?? 0;
                                                $questions = $record->total_questions ?? 0;
                                                $studentTotalCorrect += $correct;
                                                $studentTotalQuestions += $questions;
                                            @endphp

                                            <td>{{ $correct }} / {{ $questions }}</td>
                                        @endforeach
                                        <td>{{ $studentTotalCorrect }}/ {{ $studentTotalQuestions }}</td>

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
@endsection
