@props([
    'href' => '',
])

<a class="btn bg-secondary" href="{{ $href }}">
    {{ $slot }}
</a>