<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CBT Admin — Sign in</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans theme min-h-screen flex">
    <!-- Left brand panel -->
    <aside class="hidden lg:flex w-1/2 min-h-screen items-center justify-center p-10"
        style="background-color: var(--color-primary)">
        <div class="max-w-md text-white">
            <div class="inline-flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center">
                    <span class="text-xl font-bold">CBT</span>
                </div>
                <div class="text-lg font-semibold">Management Console</div>
            </div>
            <h1 class="text-3xl font-semibold leading-snug">
                Manage exams, candidates, and results in one place
            </h1>
            <p class="mt-4 text-white/80">
                Secure administrator access. Use your staff credentials to continue.
            </p>
        </div>
    </aside>

    <!-- Right form panel -->
    <main class="flex-1 flex items-center justify-center p-6" style="background-color: var(--color-bg)">
        <div class="w-full max-w-md">
            <div class="bg-white border rounded-xl shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b" style="background-color: var(--color-muted)">
                    <h2 class="text-lg font-semibold">Management sign in</h2>
                    <p class="text-sm mt-0.5" style="color: #475569">
                        Enter your credentials to continue
                    </p>
                </div>
                <div class="p-6">
                    <form class="space-y-4" action="{{ route('management.login') }}" method="POST" autocomplete="off">
                        @csrf

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div>
                            <label for="email" class="block text-sm font-medium mb-1">Email</label>
                            <input id="email" type="email" name="email" required placeholder="admin@school.edu"
                                class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none input-focus" />
                        </div>
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="password" class="block text-sm font-medium">Password</label>
                                <a href="#" class="text-sm hover:underline"
                                    style="color: var(--color-secondary)">Forgot?</a>
                            </div>
                            <input id="password" type="password" name="password" required placeholder="********"
                                class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none input-focus" />
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <label class="inline-flex items-center gap-2 select-none">
                                <input type="checkbox" class="accent-[var(--color-primary)]" />
                                <span>Remember this device</span>
                            </label>
                            <a href="{{ url('/login') }}" class="hover:underline"
                                style="color: var(--color-secondary)">Student
                                login</a>
                        </div>
                        <button type="submit" class="w-full btn-primary text-white font-medium rounded px-4 py-2">
                            Sign in
                        </button>
                    </form>
                </div>
            </div>

            <p class="mt-4 text-center text-xs" style="color: #64748b">
                Having trouble? Contact ICT support.
            </p>
        </div>
    </main>
</body>

</html>
