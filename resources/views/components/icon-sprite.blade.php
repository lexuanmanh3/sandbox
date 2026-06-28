@php
    $spritePath = public_path('frontend/img/icons/sprite.svg');
@endphp

@if(file_exists($spritePath))
    {!! file_get_contents($spritePath) !!}
@endif
