@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <header class="header" style="margin-bottom: 28px;">
        <div>
            <h1>Water Refilling Station Management System</h1>
            <p class="description">Digital operations management for customers, inventory, orders, and deliveries.</p>
        </div>
        @auth
            <div style="text-align: right;">
                <span style="font-size: 14px; color: var(--text-muted);">Logged in as:</span>
                <strong style="color: var(--text-main);">{{ Auth::user()->name }}</strong>
                @if(Auth::user()->isAdmin())
                    <span class="role-badge admin">Admin</span>
                @else
                    <span class="role-badge user">User</span>
                @endif
            </div>
        @endauth
    </header>

    <div class="dashboard-grid">
        <!-- Customers Card -->
        <section class="card module-card">
            <div class="module-header">
                <div class="module-icon-wrap">
                    <svg viewBox="0 0 24 24" class="module-icon">
                        <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="module-title">Customers</h2>
                    <p class="module-desc">Maintain registered customer profiles and phone contact details.</p>
                </div>
            </div>
            <div class="module-actions">
                <a href="{{ url('/customers') }}" class="button">View Customers</a>
                <a href="{{ url('/customers/create') }}" class="button secondary">Add Customer</a>
            </div>
        </section>

        <!-- Products Card -->
        <section class="card module-card">
            <div class="module-header">
                <div class="module-icon-wrap">
                    <svg viewBox="0 0 24 24" class="module-icon">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v3.01c0 .72.38 1.36.95 1.7L4 20c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2l1.05-11.29c.57-.34.95-.98.95-1.7V4c0-1.1-.9-2-2-2zM4 4h16v3H4V4zm14 16H6l-1-11h14l-1 11z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="module-title">Products</h2>
                    <p class="module-desc">Monitor product catalog, available stock units, and refill pricing.</p>
                </div>
            </div>
            <div class="module-actions">
                <a href="{{ url('/products') }}" class="button">View Products</a>
                <a href="{{ url('/products/create') }}" class="button secondary">Add Product</a>
            </div>
        </section>

        <!-- Orders Card -->
        <section class="card module-card">
            <div class="module-header">
                <div class="module-icon-wrap">
                    <svg viewBox="0 0 24 24" class="module-icon">
                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-2 10H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="module-title">Orders</h2>
                    <p class="module-desc">Record incoming customer purchase orders and monitor quantities.</p>
                </div>
            </div>
            <div class="module-actions">
                <a href="{{ url('/orders') }}" class="button">View Orders</a>
                <a href="{{ url('/orders/create') }}" class="button secondary">Create Order</a>
            </div>
        </section>

        <!-- Deliveries Card -->
        <section class="card module-card">
            <div class="module-header">
                <div class="module-icon-wrap">
                    <svg viewBox="0 0 24 24" class="module-icon">
                        <path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-2 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="module-title">Deliveries</h2>
                    <p class="module-desc">Schedule shipments, track delivery dates, and monitor dispatch status.</p>
                </div>
            </div>
            <div class="module-actions">
                <a href="{{ url('/deliveries') }}" class="button">View Deliveries</a>
                <a href="{{ url('/deliveries/create') }}" class="button secondary">Add Delivery</a>
            </div>
        </section>
    </div>
</div>

<style>
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 12px;
    }

    .module-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 24px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .module-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }

    .module-header {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 20px;
    }

    .module-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #e0f2fe;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .module-icon {
        width: 24px;
        height: 24px;
        fill: #0284c7;
    }

    .module-title {
        margin: 0;
        font-size: 18px;
        font-weight: 700;
        color: var(--text-main);
    }

    .module-desc {
        margin: 6px 0 0;
        font-size: 13px;
        color: var(--text-muted);
        line-height: 1.45;
    }

    .module-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
    }

    .module-actions .button {
        flex: 1;
        min-width: 120px;
        text-align: center;
        padding: 9px 12px;
        font-size: 13px;
    }
</style>
@endsection
