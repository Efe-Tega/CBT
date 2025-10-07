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
                    <div class="surface shadow-sm">
                        <div class="px-4 p-3 flex justify-between">
                            <div class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold"
                                style="background-color: var(--color-primary); color: #fff;">
                                Question 1
                            </div>
                            <span class="font-semibold text-slate-700">Time Left: 12:00</span>
                        </div>
                        <div class="p-4">
                            <div class="mt-4">
                                <pre class="surface bg-slate-100 border border-slate-200"
                                    style="padding: 2px 12px; font-size: 0.875rem; overflow:auto;">
<code>
function add(a, b) {
return a + b;
}
</code>
</pre>
                            </div>

                            <form class="mt-4">
                                <div class="p-3 surface"
                                    style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                                    <input type="radio" name="opt" id="opt1" />
                                    <label for="opt1">(A) Option one</label>
                                </div>
                                <div class="p-3 surface mt-3"
                                    style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                                    <input type="radio" name="opt" id="opt2" />
                                    <label for="opt2">(B) Option two</label>
                                </div>
                                <div class="p-3 surface mt-3"
                                    style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                                    <input type="radio" name="opt" id="opt3" />
                                    <label for="opt3">(C) Option three</label>
                                </div>
                                <div class="p-3 surface mt-3"
                                    style="display:flex; align-items:center; gap:12px; cursor:pointer;">
                                    <input type="radio" name="opt" id="opt4" />
                                    <label for="opt4">(D) Option four</label>
                                </div>
                            </form>
                        </div>
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
                        <div class="nav-grid">
                            <button class="nav-btn active" type="button">1</button>
                            <button class="nav-btn hover:bg-slate-50" type="button">2</button>
                            <button class="nav-btn answered" type="button">3</button>
                            <button class="nav-btn" type="button">4</button>
                            <button class="nav-btn" type="button">5</button>
                            <button class="nav-btn" type="button">6</button>
                            <button class="nav-btn" type="button">7</button>
                            <button class="nav-btn" type="button">8</button>
                            <button class="nav-btn" type="button">9</button>
                            <button class="nav-btn" type="button">10</button>
                            <button class="nav-btn" type="button">11</button>
                            <button class="nav-btn" type="button">12</button>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    </div>
@endsection
