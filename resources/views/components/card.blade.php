<section class="card" {{ $attributes }}>
    {{ $slot }}
</section>

<style>
    .card {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 28px;
    }
</style>