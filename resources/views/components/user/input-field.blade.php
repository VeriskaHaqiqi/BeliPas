@props([
    'id',
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'autocomplete' => null,
    'hint' => null,
    'icon' => null,
    'required' => false,
])

<div {{ $attributes->only('class')->merge(['class' => 'grid gap-1.5']) }}>
    <label for="{{ $id }}" class="flex min-h-5 items-center justify-between gap-3 text-xs font-semibold text-user-text">
        <span>{{ $label }}</span>
        @isset($labelAction)
            {{ $labelAction }}
        @endisset
    </label>

    <div class="relative flex h-12 items-center rounded-xl bg-user-surface-input px-[18px] focus-within:ring-4 focus-within:ring-user-mint/40">
        @if ($icon)
            <img class="user-auth-field-icon mr-3 shrink-0" src="{{ asset('images/'.$icon) }}" alt="" aria-hidden="true">
        @endif

        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="{{ $type }}"
            placeholder="{{ $placeholder }}"
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($required) required @endif
            {{ $attributes->except('class')->merge(['class' => 'user-auth-input min-w-0 flex-1 border-0 bg-transparent px-0 shadow-none focus:ring-0']) }}
        >

        @isset($trailing)
            <div class="ml-2 flex shrink-0 items-center">{{ $trailing }}</div>
        @endisset
    </div>

    @if ($hint)
        <p class="text-[11px] leading-4 text-user-text-muted">{{ $hint }}</p>
    @endif
</div>
