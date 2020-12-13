@props([
    'align' => 'left'
])

<div class="container my-2">
    <div class="row justify-content-center">
        <div class="col-md-8 text-{{$align}}">
            {{ $slot }}
        </div>
    </div>
</div>