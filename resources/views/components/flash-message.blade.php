@props(['type' => 'success', 'duration' => 3000])

@if (session($type))
    <div id="alert-{{ $type }}"
        class="alert alert-{{ $type === 'success' ? 'success' : ($type === 'error' ? 'danger' : 'info') }}"
        {{ $attributes }}>
        {{ session($type) }}
    </div>

    <script>
        setTimeout(() => {
            const alert = document.getElementById('alert-{{ $type }}');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove()
                }, 500);
            }
        }, {{ $duration }});
    </script>
@endif
