<div class="form-group">
    @if(isset($label))
        <label for="{{ $id }}">{{ $label }}</label>
    @endif

    {{ $slot }}
</div>

<style>
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        font-size: 16px;
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: 3px solid rgba(13, 110, 253, 0.25);
        border-color: #0d6efd;
    }
</style>