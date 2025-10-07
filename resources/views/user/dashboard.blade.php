@extends('user.main')
@section('content')
    <!-- Header -->
    <header class="header-theme border-b">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="logo.png" alt="Logo" class="w-10 h-10" />
                <div>
                    <h1 class="text-lg font-semibold leading-tight">
                        Student Dashboard
                    </h1>
                    <p class="text-sm text-slate-700 -mt-0.5">Computer Based Tests</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <div class="text-sm font-medium">Paul Candidate</div>
                    <div class="text-xs text-slate-600">CSC/2021/0123</div>
                </div>
                <img class="w-10 h-10 rounded-full object-cover" src="https://i.pravatar.cc/80?img=12" alt="Profile" />
                <a href="login.html" class="btn-muted text-sm font-medium px-3 py-1.5 rounded">Logout</a>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-6">
        <!-- Card grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            <!-- Card component -->
            <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                <div class="card-header px-4 py-2 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">Chemistry</h3>
                    <span
                        class="text-[10px] uppercase bg-emerald-500/20 text-emerald-200 border border-emerald-300/40 rounded px-2 py-0.5">Active</span>
                </div>
                <div class="p-4 text-sm space-y-2">
                    <p><span class="text-slate-500">Subject:</span> Chemistry</p>
                    <p><span class="text-slate-500">Class:</span> SS3</p>
                </div>
                <div class="bg-[var(--color-bg)] px-4 py-3">
                    <a href="index.html?examId=chem"
                        class="inline-flex items-center justify-center btn-secondary text-sm rounded px-3 py-2">Start
                        Chemistry exam</a>
                </div>
            </div>

            <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                <div class="card-header px-4 py-2 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">MATHS</h3>
                    <span
                        class="text-[10px] uppercase bg-rose-500/20 text-rose-200 border border-rose-300/40 rounded px-2 py-0.5">done</span>
                </div>
                <div class="p-4 text-sm space-y-2">
                    <p><span class="text-slate-500">Subject:</span> MATHS</p>
                    <p><span class="text-slate-500">Class:</span> SS3</p>
                </div>
                <div class="bg-[var(--color-bg)] px-4 py-3">
                    <a href="index.html?examId=math"
                        class="inline-flex items-center justify-center btn-secondary text-sm rounded px-3 py-2">Start
                        MATHS exam</a>
                </div>
            </div>

            <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                <div class="card-header px-4 py-2 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">General Subject</h3>
                    <span
                        class="text-[10px] uppercase bg-rose-500/20 text-rose-200 border border-rose-300/40 rounded px-2 py-0.5">done</span>
                </div>
                <div class="p-4 text-sm space-y-2">
                    <p><span class="text-slate-500">Subject:</span> General Subject</p>
                    <p><span class="text-slate-500">Class:</span> SS3</p>
                </div>
                <div class="bg-[var(--color-bg)] px-4 py-3">
                    <a href="index.html?examId=general"
                        class="inline-flex items-center justify-center btn-secondary text-sm rounded px-3 py-2">Start
                        General Subject exam</a>
                </div>
            </div>

            <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                <div class="card-header px-4 py-2 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">ENGLISH</h3>
                    <span
                        class="text-[10px] uppercase bg-emerald-500/20 text-emerald-200 border border-emerald-300/40 rounded px-2 py-0.5">Active</span>
                </div>
                <div class="p-4 text-sm space-y-2">
                    <p><span class="text-slate-500">Subject:</span> ENGLISH</p>
                    <p><span class="text-slate-500">Class:</span> SS3</p>
                </div>
                <div class="bg-[var(--color-bg)] px-4 py-3">
                    <a href="index.html?examId=eng"
                        class="inline-flex items-center justify-center btn-secondary text-sm rounded px-3 py-2">Start
                        ENGLISH exam</a>
                </div>
            </div>

            <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                <div class="card-header px-4 py-2 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">PHYSICS</h3>
                    <span
                        class="text-[10px] uppercase bg-emerald-500/20 text-emerald-200 border border-emerald-300/40 rounded px-2 py-0.5">Active</span>
                </div>
                <div class="p-4 text-sm space-y-2">
                    <p><span class="text-slate-500">Subject:</span> PHYSICS</p>
                    <p><span class="text-slate-500">Class:</span> SS3</p>
                </div>
                <div class="bg-[var(--color-bg)] px-4 py-3">
                    <a href="index.html?examId=phy"
                        class="inline-flex items-center justify-center btn-secondary text sm rounded px-3 py-2">Start
                        PHYSICS exam</a>
                </div>
            </div>

            <div class="bg-white border border-slate-300 rounded shadow-sm overflow-hidden">
                <div class="card-header px-4 py-2 flex items-center justify-between">
                    <h3 class="text-sm font-semibold">GEOGRAPHY</h3>
                    <span
                        class="text-[10px] uppercase bg-emerald-500/20 text-emerald-200 border border-emerald-300/40 rounded px-2 py-0.5">Active</span>
                </div>
                <div class="p-4 text-sm space-y-2">
                    <p><span class="text-slate-500">Subject:</span> GEOGRAPHY</p>
                    <p><span class="text-slate-500">Class:</span> SS3</p>
                </div>
                <div class="bg-[var(--color-bg)] px-4 py-3">
                    <a href="index.html?examId=geo"
                        class="inline-flex items-center justify-center btn-secondary text-sm rounded px-3 py-2">Start
                        GEOGRAPHY exam</a>
                </div>
            </div>
        </div>
    </main>
@endsection
