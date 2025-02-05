@props([
    'method' => 'GET',
    'flat' => false,
])

@php
    $method = strtoupper($method);
    $changedMethod = $method !== "POST" && $method !== "PUT" && $method !== "PATCH" && $method !== "DELETE"
            ? 'GET'
            : 'POST'
@endphp

<form action="{{ $attributes->get('action') }}" {{ $attributes->class(['gap-4 flex flex-col' => !$flat]) }} method="{{ $changedMethod }}">
    @if ($method != 'POST' && $method !== 'GET')
        @method($method)  
    @endif
    @if($method != 'GET')
        @csrf
    @endif
    
    {{ $slot }}
</form>