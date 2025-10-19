@extends('backend.backend-main')

@section('title')
    {{ __('Subject Questions') }}
@endsection

@section('backend-content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Questions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Nasdec</a>
                        </li>
                        <li class="breadcrumb-item active">questions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        @foreach ($subjectsByClass as $classId => $subjects)
            @php
                $className = $subjects->first()->class->name ?? 'Unknown Class';
            @endphp

            <div class="col-xl-12 mb-4">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">{{ $className }} Subjects</h4>

                        <x-table :columns="['S/N', 'Subject', 'Class', 'Duration', 'Status', 'Action']">
                            @foreach ($subjects as $key => $subject)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $className }}</td>
                                    <td>{{ $subject->duration }} minutes</td>
                                    <td>
                                        <div class="square-switch">
                                            <input type="checkbox" id="subject-switch-{{ $subject->id }}" switch="bool"
                                                class="toggle-status" data-id="{{ $subject->id }}"
                                                {{ $subject->status === 'active' ? 'checked' : '' }} />
                                            <label for="subject-switch-{{ $subject->id }}" data-on-label="Active"
                                                data-off-label="Inactive"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('management.questions.page', $subject->id) }}"
                                            class="btn btn-sm btn-primary editSubjectBtn">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>

                    </div>
                </div>
            </div> <!-- end col -->
        @endforeach
    </div> <!-- end row -->

    {{-- For Teachers Based on Assigned subject --}}
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">All Subjects</h4>

                    <x-table :columns="['S/N', 'Subject', 'Class', 'Action']">
                        @foreach ($subjects as $key => $subject)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->class->name }}</td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row --> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.toggle-status').forEach(toggle => {
                toggle.addEventListener('change', async function() {
                    const id = this.dataset.id;

                    try {
                        const response = await fetch(`/management/subjects/${id}/toggle`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                        });

                        const data = await response.json();

                        if (data.success) {
                            console.log(`Subject ${id} set to ${data.status}`);

                        } else {
                            alert('Failed to update status');
                        }
                    } catch (error) {
                        console.error(error);
                        alert('An error occured.');
                    }
                });
            });
        });
    </script>
@endsection
