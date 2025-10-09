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
                            <p class="text-sm font-medium">Welcome, Paul</p>
                            <p class="text-xs text-slate-600">English Language</p>
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

        <!-- Main Content -->
        <main class="flex-1">
            <div class="max-w-7xl mx-auto px-4 py-6 grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Question area -->
                <section class="md:col-span-8">
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

            // Build HTML
            container.innerHTML = `
            <div class="px-4 p-3 flex justify-between">
                <div class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold"
                    style="background-color: var(--color-primary); color: #fff;">
                    Question ${index + 1}
                </div>
                <span class="font-semibold text-slate-700">Time Left: 12:00</span>
            </div>

            <div class="p-4">
                <div class="mt-2 text-sm text-slate-800 font-medium leading-relaxed">
                    
                    <pre class="surface bg-slate-100 border border-slate-200"
style="padding: 2px 12px; font-size: 0.875rem; overflow:auto;">
<code>
${q.question_text}
</code>
</pre>
                </div>

                <form class="mt-4">
                    ${renderOption('A', q.option_a, q.id)}
                    ${renderOption('B', q.option_b, q.id)}
                    ${renderOption('C', q.option_c, q.id)}
                    ${renderOption('D', q.option_d, q.id)}     
                </form>
            </div>
        `;

            // Re-check selected answer if user navigates back
            if (answers[q.id]) {
                const selectedRadio = document.querySelector(`input[value="${answers[q.id]}"]`);
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

        // Save answer via AJAX
        async function saveAnswer(questionId, selectedOption) {
            try {
                await fetch(saveUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        question_id: questionId,
                        answer: selectedOption,
                    }),
                });

                console.log(`Saved Q${questionId}: ${selectedOption}`);

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
                saveAnswer(q.id, e.target.value);
            }
        });

        // Create navigation buttons
        questions.forEach((_, i) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.textContent = i + 1;
            btn.className = 'nav-btn';
            btn.addEventListener('click', () => {
                currentIndex = i;
                renderQuestion(currentIndex);
            });
            navigator.appendChild(btn);
        });

        // Next & Prev
        document.getElementById('nextBtn').addEventListener('click', () => {
            if (currentIndex < questions.length - 1) {
                currentIndex++;
                renderQuestion(currentIndex);
            }
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                renderQuestion(currentIndex);
            }
        });

        // Initialize first question
        renderQuestion(currentIndex)
    });
</script>
