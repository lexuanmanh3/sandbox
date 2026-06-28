@props([
    'name',
    'size' => null,
])

@php
    /*
     * Icon component dung SVG sprite da nhung bang <x-icon-sprite />.
     *
     * Cach dung:
     *   <x-icon name="person" />
     *   <x-icon name="logout" class="w-5 h-5 text-red-500" />
     *   <x-icon name="home" size="32" />
     */
    $iconName = preg_replace('/[^a-z0-9_-]/i', '', $name);
    $hasIcon = $iconName
        && file_exists(public_path('frontend/img/icons/sprite.svg'))
        && file_exists(public_path('frontend/img/icons/' . $iconName . '.svg'));

    $iconHref = '#icon-' . $iconName;
@endphp

@if($hasIcon)
    <svg
        {{ $attributes->merge(['class' => 'icon']) }}
        @if($size) width="{{ $size }}" height="{{ $size }}" @endif
        aria-hidden="true"
        focusable="false"
        fill="currentColor"
    >
        <use href="{{ $iconHref }}" xlink:href="{{ $iconHref }}"></use>
    </svg>
@else
    <span {{ $attributes->merge(['class' => 'icon icon--missing']) }} title="{{ $name }}" aria-hidden="true"></span>
@endif
