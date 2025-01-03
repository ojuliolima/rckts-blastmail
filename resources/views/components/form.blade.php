@props([
    'method' => 'GET',
])

@php
    $method = strtoupper($method);
    $changedMethod = $method !== "POST" && $method !== "PUT" && $method !== "PATCH" && $method !== "DELETE"
            ? 'GET'
            : 'POST'
@endphp

<form action="{{ $attributes->get('action') }}" {{ $attributes->class(['gap-4 flex flex-col']) }} method="{{ $changedMethod }}">
    @if ($method != 'POST' && $method !== 'GET')
        @method($method)        
    @endif
    @csrf
    {{ $slot }}
</form>