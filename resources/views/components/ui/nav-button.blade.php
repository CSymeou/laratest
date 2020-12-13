@props([
    'href' => '',
    'text' => 'Lorem'
])

<a type="submit" class="btn btn-primary" href="{{ $href }}">
    {{ $text }}
</a>