<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CBT — Summary of attempt</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900 font-sans min-h-screen theme">
    <!-- Top bar / breadcrumb mimic -->
    <header class="bg-white border-b border-slate-200 header-theme">
        <div class="max-w-5xl mx-auto px-4 py-4">
            <div class="text-xs text-slate-600">
                Dashboard / My courses / GST202_CDL /
                <span class="text-slate-900">Summary of attempt</span>
            </div>
            <h1 class="mt-1 text-lg font-semibold">GST202_CDL</h1>
            <div class="text-sm text-slate-700">Summary of attempt</div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-6">
        <!-- Summary table -->
        <div class="bg-white border border-slate-200 rounded overflow-hidden">
            <div class="text-white text-sm font-medium px-4 py-2" style="background-color: var(--color-secondary)">
                Summary of attempt
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr
                            style="
                  background-color: color-mix(
                    in srgb,
                    var(--color-secondary) 12%,
                    white
                  );
                  color: #0f172a;
                ">
                            <th class="text-left px-4 py-2 w-32">Question</th>
                            <th class="text-left px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentAnswers as $answer)
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-2">1</td>
                                <td class="px-4 py-2">{{ $answer->selected_answer ? 'Answer Saved' : 'No Answer' }}</td>
                            </tr>
                        @endforeach

                        {{-- <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">2</td>
                            <td class="px-4 py-2">Answer saved</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">3</td>
                            <td class="px-4 py-2">Answer saved</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">4</td>
                            <td class="px-4 py-2">Answer saved</td>
                        </tr>
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-2">5</td>
                            <td class="px-4 py-2">Answer saved</td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Actions area -->
        <div class="mt-6 bg-white border border-slate-200 rounded p-4">
            <div class="flex items-center justify-between mb-4">
                <a href="index.html"
                    class="inline-flex items-center justify-center text-xs font-semibold uppercase tracking-wide btn-muted rounded px-4 py-2">Return
                    to attempt</a>
                <div class="text-xs text-slate-600">
                    Time left
                    <span class="ml-2 inline-flex items-center px-2 py-1 rounded"
                        style="
                background-color: var(--color-bg);
                border: 1px solid var(--color-muted);
              ">02:27:39</span>
                </div>
            </div>
            <div class="text-xs text-slate-600 mb-3">
                This attempt must be submitted by
                <span class="font-medium">Saturday, 2 November 2024, 12:14 PM</span>.
            </div>
            <button id="finalizeExamBtn"
                class="w-full sm:w-auto inline-flex items-center justify-center btn-secondary text-white text-sm font-semibold rounded px-5 py-2">
                Submit all and finish
            </button>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const finalizeBtn = document.getElementById("finalizeExamBtn");

            finalizeBtn?.addEventListener("click", async () => {
                try {
                    // Prevent double-click
                    finalizeBtn.disabled = true;
                    finalizeBtn.textContent = "Submitting...";

                    const examId = "{{ $exam_id ?? '' }}";
                    console.log(examId);

                    const res = await fetch("{{ route('exam.finalize') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            exam_id: examId
                        })
                    });

                    if (res.redirected) {
                        window.location.href = res.url;
                    } else {
                        window.location.href = "/loginapp";
                    }
                } catch (error) {

                }
            })
        });
    </script>
</body>

</html>
