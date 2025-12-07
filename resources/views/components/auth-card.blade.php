@props(['maxWidth' => 'md'])

@php
$maxWidthClass = [
    'sm' => 'max-w-sm',
    'md' => 'max-w-md',
    'lg' => 'max-w-lg',
    'xl' => 'max-w-xl',
    '2xl' => 'max-w-2xl',
][$maxWidth];
@endphp

<div class="{{ $maxWidthClass }} w-full mx-auto glassmorphism bg-white/70 shadow-2xl rounded-3xl p-8 sm:p-10 border border-white/50 backdrop-blur-xl max-h-[90vh] overflow-y-auto">
    {{ $slot }}
</div>
