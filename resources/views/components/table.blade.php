<table id="datatable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        @foreach ($columns as $column)
            <th>{{ $column }}</th>
        @endforeach
    </thead>

    <tbody id="tableBody">
        {{ $slot }}
    </tbody>
</table>
