<header class="page-header">
    <h1>{{ $title }}</h1>

    @if(isset($description))
        <p class="description">{{ $description }}</p>
    @endif
</header>

<style>
    .page-header {
        margin-bottom: 24px;
    }

    .page-header h1 {
        margin: 0;
    }

    .page-header .description {
        color: #6c757d;
        margin-top: 6px;
    }
</style>