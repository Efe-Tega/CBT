@extends('user.main')
@section('content')
    <!-- Header -->
    <header class="header-theme border-b">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="{{ asset('assets/logo/logo.png') }}" alt="Logo" class="w-10 h-10" />
                <div>
                    <h1 class="text-lg font-semibold leading-tight">
                        Student Dashboard
                    </h1>
                    <p class="text-sm text-slate-700 -mt-0.5">Computer Based Tests</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <div class="text-sm font-medium">{{ $student->firstname }} {{ $student->middlename }}
                        {{ $student->lastname }}</div>
                    <div class="text-xs text-slate-600">{{ $student->registration_number }}</div>
                </div>
                <img class="w-10 h-10 rounded-full object-cover" src="{{ asset('assets/default.jpg') }}" alt="Profile" />
                <a href="{{ route('user.logout') }}" class="btn-muted text-sm font-medium px-3 py-1.5 rounded">Logout</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <!-- Card grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Card component -->
            @foreach ($subjects as $subject)
                <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                    <div class="card-header px-4 py-2 flex items-center justify-between">
                        <h3 class="text-sm font-semibold">{{ $subject->name }}</h3>
                        @if (in_array($subject->id, $finalizedSubjectIds))
                            <span
                                class="text-[10px] uppercase bg-red-600 text-rose-200 border border-rose-300 rounded px-2 py-0.5">done</span>
                        @else
                            <span
                                class="text-[10px] uppercase bg-green-700 text-emerald-200 border border-green-300/40 rounded px-2 py-0.5">Active</span>
                        @endif
                    </div>
                    <div class="p-4 text-sm space-y-2">
                        <p><span class="text-slate-500">Subject:</span> {{ $subject->name }}</p>
                        <p><span class="text-slate-500">Class:</span> {{ $subject->class->name }}</p>
                    </div>
                    <div class="bg-[var(--color-bg)] px-4 py-3">
                        @if (in_array($subject->id, $finalizedSubjectIds))
                            <button class="inline-flex items-center justify-center bg-gray-400 text-sm rounded px-3 py-2"
                                disabled>Start
                                {{ $subject->name }} Exam</button>
                        @else
                            <a href="{{ route('user.questions', ['id' => $subject->id]) }}"
                                class="inline-flex items-center justify-center btn-secondary text-sm rounded px-3 py-2">Start
                                {{ $subject->name }} Exam</a>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection
