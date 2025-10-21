@extends('user.main')
@section('content')
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="header-theme border-b">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('assets/logo/logo.png') }}" alt="Nasdec Logo" class="w-10 h-10" />
                    <div>
                        <h1 class="text-lg font-semibold leading-tight">
                            Nasdec Royal School
                        </h1>
                        <p class="text-sm text-slate-700 -mt-0.5">
                            Computer Based Test (CBT) Platform
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <img class="w-10 h-10 rounded-full object-cover" src="https://i.pravatar.cc/80?img=12"
                            alt="User" />
                        <div class="text-right">
                            <p class="text-sm font-medium">Welcome, {{ Auth::user()->firstname }}</p>
                            <p class="text-xs text-slate-600">{{ $subjectName }}</p>
                        </div>
                    </div>

                    <button id="submitBtn"
                        class="inline-flex items-center gap-2 btn-primary text-sm font-medium px-4 py-2 rounded">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 10-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" />
                        </svg>
                        Submit
                    </button>

                </div>
            </div>
        </header>

        <!-- Timer -->
        <div class="max-w-7xl mx-auto px-4 py-3 flex justify-end">
            <h2 class="text-lg font-bold">
                Time Left: <span id="timer"></span>
            </h2>
        </div>

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Question area -->
                <section class="md:col-span-8">
                    <!-- Add this above #questionContainer -->
                    <div id="questionContainer" class="surface shadow-sm">
                    </div>

                    <!-- Controls -->
                    <div class="mt-6 flex items-center justify-between">
                        <button id="prevBtn"
                            class="inline-flex items-center gap-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 text-sm font-medium px-4 py-2 rounded">
                            <span class="mr-1">⟵</span> PREV
                        </button>

                        <button id="nextBtn"
                            class="inline-flex items-center gap-2 bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 text-sm font-medium px-4 py-2 rounded">
                            NEXT <span class="ml-1">⟶</span>
                        </button>
                    </div>
                </section>

                <!-- Sidebar: Navigator -->
                <aside class="col-span-4">
                    <div class="surface p-4">
                        <div class="nav-grid" id="navigator">
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questions = @json($questions);
        const currentExamId = {{ $exam->exam_id }};
        const time =
            "{{ \Carbon\Carbon::parse($session->end_time)->setTimezone('Africa/Lagos')->toIso8601String() }}";
        const endTime = new Date(time).getTime();
        const progressUrl = `/exam-progress/${currentExamId}`;
        const saveUrl = "{{ route('save.answer') }}";
        const csrfToken = "{{ csrf_token() }}";

        let currentIndex = 0;
        const answers = {};
        const container = document.getElementById('questionContainer');
        const navigator = document.getElementById('navigator');

        // Render a single question
        function renderQuestion(index) {
            const q = questions[index];
            if (!q) return;

            // check to show instruction
            const prevInstructionId = index > 0 ? questions[index - 1].instruction_id : null;
            let instructionHTML = "";

            if (q.instruction && q.instruction.id !== prevInstructionId) {
                instructionHTML = `
                <div class="p-3 mb-3 border border-slate-300 bg-slate-50 rounded">
                <strong class="block text-slate-700">Instruction:</strong>
                <div class="text-slate-800 text-sm mt-1">
                    ${q.instruction.text}
                </div>
                </div>
                `;
            }

            let questionHTML = "";
            if (q.question_text) {
                questionHTML = `
        <div class="mt-2 text-sm text-slate-800 font-medium leading-relaxed">
            <pre class="surface bg-slate-100 border border-slate-200"
            style="padding: 2px 12px; font-size: 0.875rem; overflow:auto;">
                <code>${q.question_text}</code>
            </pre>
        </div>
    `;
            }

            // Build HTML
            container.innerHTML = `
            <div class="px-4 p-3 flex justify-between">
                <div class="flex bg-white border border-slate-300 hover:bg-slate-50 text-slate-800 px-2 py-1 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12" />
                        <polyline points="12 19 5 12 12 5" />
                    </svg>
                    <a href="{{ route('user.dashboard') }}">Back</a>
                    
                </div>
                <div class="inline-flex items-center rounded-xl px-3 py-1 text-lg font-bold"
                    style="background-color: var(--color-primary); color: #fff;">
                    Question ${index + 1}
                </div>
            </div>

            <div class="p-4">
                ${instructionHTML}
                ${questionHTML}

                <form class="mt-4">
                    ${renderOption('A', q.option_a, q.id)}
                    ${renderOption('B', q.option_b, q.id)}
                    ${q.option_c ? renderOption('C', q.option_c, q.id) : ''}
                    ${q.option_d ? renderOption('D', q.option_d, q.id) : ''}  
                </form>
            </div>
        `;

            // Re-check selected answer if user navigates back
            if (answers[q.id]) {
                const selectedRadio = container.querySelector(
                    `input[name="q${q.id}"][value="${answers[q.id]}"]`);
                if (selectedRadio) selectedRadio.checked = true;
            }

            // Highlight current question in navigator
            document.querySelectorAll('.nav-btn').forEach((btn, i) => {
                btn.classList.toggle('active', i === index);
            });
        }

        // Generate option markup 
        function renderOption(letter, text, questionId) {
            const checked = (answers[questionId] === letter) ? 'checked' : '';
            return `
            <div class="p-3 surface mt-3 flex items-center gap-3 cursor-pointer">
                <input type="radio" name="q${questionId}" id="opt${letter}" value="${letter}" ${checked} />
                <label for="opt${letter}" class="cursor-pointer">(${letter}) ${text}</label>
            </div>
        `;
        }

        async function loadProgress() {
            try {
                const res = await fetch(progressUrl);
                const data = await res.json();

                // Restore selected options
                if (data.answers && Array.isArray(data.answers)) {
                    data.answers.forEach(item => {
                        const question = questions.find(q => q.id === item.question_id);
                        if (question) {
                            answers[question.id] = item.selected_answer;

                            // Mark navigator button only if answered (not null)
                            // const navBtn = navigator.children[questions.findIndex(q => q.id === item
                            //     .question_id)];
                            // if (navBtn) navBtn.classList.add('answered');
                            const navBtn = navigator.children[questions.indexOf(question)];
                            if (item.selected_answer && item.selected_answer !== "null") {
                                navBtn.classList.add('answered');
                            } else {
                                navBtn.classList.remove('answered');
                            }
                        }
                    });
                }

                renderQuestion(currentIndex);
                console.log("Progress restored successfully");
            } catch (error) {
                console.error("Error loading progress:", error);
            }
        }

        // Save answer via AJAX
        async function saveAnswer(examId, questionId, selectedOption) {
            try {
                await fetch(saveUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        exam_id: examId,
                        question_id: questionId,
                        answer: selectedOption,
                    }),
                });

                console.log(`Saved Q${questionId} for Exam ${examId}: ${selectedOption}`);

            } catch (error) {
                console.error("Error saving answer:", error);

            }
        }

        // Save selected answer when a radio is clicked
        container.addEventListener('change', (e) => {
            if (e.target.type === 'radio') {
                const q = questions[currentIndex];
                answers[q.id] = e.target.value;

                // Mark as answered in navigator
                const navBtn = navigator.children[currentIndex];
                navBtn.classList.add('answered');

                // Save immediately
                saveAnswer(currentExamId, q.id, e.target.value);
            }
        });

        // Mark skipped question when moving next/prev
        function handleNavigation(newIndex) {
            const currentQuestion = questions[currentIndex];
            const hasAnswer = !!answers[currentQuestion.id];

            if (!hasAnswer) {
                // Save skipped question with null answer
                answers[currentQuestion.id] = null;
                saveAnswer(currentExamId, currentQuestion.id, null);
            }

            currentIndex = newIndex;
            renderQuestion(currentIndex)
            updateNavigator();
        }

        // Update navigator button state
        function updateNavigator() {
            questions.forEach((q, i) => {
                const btn = navigator.children[i];
                if (answers[q.id]) {
                    btn.classList.add('answered');
                } else {
                    btn.classList.remove('answered');
                }
            });
        }

        // Create navigation buttons
        questions.forEach((_, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = i + 1;
            btn.className = 'nav-btn';
            btn.addEventListener('click', () => handleNavigation(i));
            navigator.appendChild(btn);
        });

        // Next & Prev
        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentIndex < questions.length - 1) {
                handleNavigation(currentIndex + 1);
            }
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentIndex > 0) {
                handleNavigation(currentIndex - 1);
            }
        });

        // Submit button
        async function submitExam(auto = false) {
            try {
                const currentQuestion = questions[currentIndex];

                // Handle current question (whether answered or not)
                if (!answers[currentQuestion.id]) {
                    answers[currentQuestion.id] = null;
                    await saveAnswer(currentExamId, currentQuestion.id, null);
                } else {
                    await saveAnswer(currentExamId, currentQuestion.id, answers[currentQuestion.id]);
                }

                // Save unanswered as null before submit 
                for (const q of questions) {
                    if (!answers[q.id]) {
                        answers[q.id] = null;
                        await saveAnswer(currentExamId, q.id, null);
                    }
                }

                // Send final submission
                const response = await fetch("{{ route('exam.finalize') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        exam_id: currentExamId,
                        auto: auto
                    })
                });

                if (response.redirected) {
                    window.location.href = response.url;
                }

            } catch (error) {
                console.error("Exam submission failed:", error);
            }
        }

        async function updateTimer() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance <= 0) {
                document.getElementById("timer").innerHTML = "Time's up!";

                // Auto-submit
                await submitExam(true);
                return;
            }

            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            const timerEl = document.getElementById("timer")

            timerEl.innerHTML = `${minutes}m ${seconds}s`;

            if (distance <= 5 * 60 * 1000) {
                timerEl.style.color = "red";
            } else {
                timerEl.style.color = "inherit"; // reset to default
            }

            // Update every second
            setTimeout(updateTimer, 1000)
        }

        updateTimer();

        // Submit button to redirect to summary
        document.getElementById('submitBtn')?.addEventListener('click', () => {

            // Pass endTime in ISO format (same as used before)
            const url = new URL("{{ route('exam.summary') }}", window.location.origin);
            url.searchParams.set("end_time", new Date(endTime).toISOString());
            url.searchParams.set("subject_id", `${questions[0].subject_id}`);
            window.location.href = url.toString();
        });

        // Initialize
        loadProgress().then(() => {
            renderQuestion(currentIndex);
        });
    });
</script>
