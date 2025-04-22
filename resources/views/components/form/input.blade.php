@props([
    'type' => 'text',
    'name',
    'placeholder',
    'icon' => null,
    'isPassword' => false
])

@php
    $hasError = $errors->has($name);
@endphp

<div class="relative">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ old($name) }}"
        class="peer w-full px-4 py-3 rounded-xl bg-gray-100 focus:outline-none focus:ring-2 {{ $hasError ? 'ring-red-400' : 'focus:ring-purple-400' }} transition"
        autocomplete="{{ $name }}"
        {{ $attributes }}
    >
    @if ($hasError)
        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-red-400">
            ✕
        </div>
    @elseif (old($name))
        <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-green-500">
            ✓
        </div>
    @endif
</div>
@if ($isPassword)
    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 cursor-pointer">
        <i class="fas fa-eye"></i>
    </div>
@endif