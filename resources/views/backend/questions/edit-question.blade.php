@extends('backend.backend-main')

@section('title')
    {{ __('Edit Questions') }}
@endsection

@section('backend-content')
    @php
        $subjectId = $question->subject_id;
        $subject = App\Models\Subject::find($subjectId);
        $instructions = App\Models\Instruction::where('subject_id', $subjectId)->get();
    @endphp
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
                    <h4 class="card-title mb-3">Edit Question</h4>
                    <p class="card-title-desc">All fields are required.
                    </p>

                    <form novalidate method="POST" action="{{ route('management.update.question') }}">
                        @csrf

                        <input type="hidden" name="quesiton_id" id="question_id" value="{{ $question->id }}">
                        <input type="hidden" id="" name="subject_id" value="{{ $subjectId }}">

                        <div class="row">
                            <div class="mb-3">
                                <label for="instruction_id" class="form-label">Instruction (optional)</label>
                                <select name="instruction_id" id="instruction_id" class="form-control">
                                    <option value="">-- Select existing instruction --</option>
                                    @foreach ($instructions as $instruction)
                                        <option value="{{ $instruction->id }}"
                                            {{ $instruction->id == $question->instruction_id ? 'selected' : '' }}>
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
                                <textarea id="elm1" name="question_text"> {{ $question->question_text }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Option A</label>
                                    <textarea class="form-control" name="option_a" id="option_a">{{ $question->option_a }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Option B</label>
                                    <textarea class="form-control" name="option_b" id="option_b">{{ $question->option_b }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Option C</label>
                                    <textarea class="form-control" name="option_c" id="option_c">{{ $question->option_c }}</textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Option D</label>
                                    <textarea class="form-control" name="option_d" id="option_d">{{ $question->option_d }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="" class="form-label">Option E</label>
                                    <textarea class="form-control" name="option_e" id="option_e">{{ $question->option_e }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Correct Answer</label>
                                    <select class="form-select" id="correct_answer" name="correct_answer" required>
                                        <option value="A" {{ $question->correct_answer == 'A' ? 'selected' : '' }}>A
                                        </option>
                                        <option value="B" {{ $question->correct_answer == 'B' ? 'selected' : '' }}>B
                                        </option>
                                        <option value="C" {{ $question->correct_answer == 'C' ? 'selected' : '' }}>C
                                        </option>
                                        <option value="D" {{ $question->correct_answer == 'D' ? 'selected' : '' }}>D
                                        </option>
                                        <option value="E" {{ $question->correct_answer == 'E' ? 'selected' : '' }}>E
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="" class="form-label">Marks</label>
                                    <select class="form-select" id="marks" name="marks" required>
                                        <option value="1" {{ $question->marks == '1' ? 'selected' : '' }}>1
                                        </option>
                                        <option value="2" {{ $question->marks == '2' ? 'selected' : '' }}>2
                                        </option>
                                        <option value="3" {{ $question->marks == '3' ? 'selected' : '' }}>3
                                        </option>
                                        <option value="4" {{ $question->marks == '4' ? 'selected' : '' }}>4
                                        </option>
                                        <option value="5" {{ $question->marks == '5' ? 'selected' : '' }}>5
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-sm-8 mx-auto mt-4">
                            <button id=""
                                onclick="this.disabled=true; this.form.submit(); this.innerText='Updating...';"
                                type="submit" class="btn btn-info w-100">Update
                                Question</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end card -->
        </div> <!-- end col -->

    </div> <!-- end row -->
@endsection
