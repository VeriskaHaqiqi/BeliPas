@props(['type' => 'submit'])

<button type="{{ $type }}" {{ $attributes->merge(['class' => 'user-auth-primary-button']) }}>
    {{ $slot }}
</button>
