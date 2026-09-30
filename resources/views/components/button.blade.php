@if($type === 'link')
    <a href="{{ $href ?? '#' }}" class="button {{ $variant ?? '' }}">
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type ?? 'button' }}"
        class="button {{ $variant ?? '' }}"
    >
        {{ $slot }}
    </button>
@endif

<style>
    .button {
        display: inline-block;
        padding: 10px 16px;
        background: #212529;
        color: white;
        border: none;
        text-decoration: none;
        border-radius: 6px;
        cursor: pointer;
        margin-right: 8px;
    }

    .button:focus {
        outline: 3px solid rgba(13, 110, 253, 0.25);
        outline-offset: 2px;
    }

    .button.secondary {
        background: #6c757d;
    }
</style>