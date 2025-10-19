<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CBT Portal — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100 text-slate-900 font-sans min-h-screen flex items-center justify-center p-4 theme">
    <div class="w-full max-w-4xl">
        <div
            class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden grid grid-cols-1 md:grid-cols-2">
            <!-- Left: School Logo -->
            <div class="p-8 flex items-center justify-center" style="background-color: var(--color-muted)">
                <img src="{{ asset('assets/logo/logo.png') }}" alt="School logo"
                    class="max-h-64 w-auto object-contain" />
            </div>

            <!-- Right: Login form -->
            <div class="p-6 md:p-8">
                <div class="mb-6">
                    <p class="text-xs" style="color: #475569">Welcome to</p>
                    <h1 class="text-xl font-semibold leading-tight">
                        CBT Student Portal
                    </h1>
                </div>

                <form id="loginForm" action="{{ route('login') }}" method="POST" class="space-y-4" autocomplete="off">
                    @csrf

                    @if ($errors->any())
                        <div class="text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div>
                        <label for="matric" class="block text-sm font-medium mb-1">Username/Registration
                            Number</label>
                        <input id="matric" type="text" required placeholder="e.g., CSC/2021/0123"
                            name="registration_number"
                            class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none input-focus" />
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium mb-1">Password</label>
                        <input id="password" type="password" name="password" required placeholder="********"
                            class="w-full rounded border border-slate-300 px-3 py-2 focus:outline-none input-focus" />
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <label class="inline-flex items-center gap-2 select-none">
                            <input id="remember" type="checkbox" class="accent-[var(--color-primary)]" />
                            <span>Remember me</span>
                        </label>
                        <a href="#" class="hover:underline" style="color: var(--color-secondary)">Forgot
                            password?</a>
                    </div>

                    <button type="submit" class="w-full btn-primary text-white font-medium rounded px-4 py-2">
                        Sign in
                    </button>
                </form>
                <div class="mt-6 text-xs" style="color: #475569">
                    By signing in you agree to the exam rules and honor code.
                </div>
            </div>
        </div>

        <p class="mt-4 text-center text-sm" style="color: #475569">
            Having issues? Contact the exam administrator.
        </p>
    </div>

</body>

</html>
