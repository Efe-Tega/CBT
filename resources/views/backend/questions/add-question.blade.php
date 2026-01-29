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
                                <a href="{{ route('management.questions.page', $subject->id) }}">Questions</a>
                            </li>
                            <li class="breadcrumb-item active">{{ strtolower($subject->name) }}</li>
                        </ol>
                    </div>
                </div>
                <div>
                    <a href="{{ route('management.questions.page', $subject->id) }}"
                        class="btn btn-primary btn-sm d-flex align-items-center waves-effect waves-light">
                        <i class="ri-rewind-mini-fill font-size-20"></i>
                        <span style="margin-left: 5px; font-size: 16px; font-weight: bold;">Back</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Add Question <span class="badge bg-info">{{ $totalQues }}</span> </h4>
                    <p class="card-title-desc">All fields are required.
                    </p>

                    @php
                        $text = strtolower($subject->name);
                    @endphp

                    <form novalidate method="POST" action="{{ route('management.store.question') }}">
                        @csrf

                        <input type="hidden" name="id" id="question_id">
                        <input type="hidden" id="" name="subject_id" value="{{ $subject->id }}">

                        {{-- @if (str_contains($text, 'english') || str_contains($text, 'math')) --}}
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
                        {{-- @endif --}}

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
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Option E</label>
                                    <textarea class="form-control" name="option_e" id="option_e"></textarea>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Correct Answer</label>
                                    <select class="form-select" id="correct_answer" name="correct_answer" required>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Marks</label>
                                    <select class="form-select" id="marks" name="marks" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-8 mx-auto mt-4">
                            <button id="saveBtn"
                                onclick="this.disabled=true; this.form.submit(); this.innerText='Submitting...';"
                                type="submit" class="btn btn-primary w-100">Submit
                                Question</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->

    </div> <!-- end row -->
@endsection
