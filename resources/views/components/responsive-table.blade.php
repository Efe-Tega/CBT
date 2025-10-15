<div class="table-responsive">
    <table class="table mb-0">
        <thead>
            @foreach ($columns as $column)
                <th>{{ $column }}</th>
            @endforeach
        </thead>

        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
