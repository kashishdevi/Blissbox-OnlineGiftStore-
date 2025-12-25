{{-- Admin Navigation Menu --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4" style="background: linear-gradient(135deg, #1e293b, #334155) !important; border-radius: 12px; margin-bottom: 2rem !important;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-user-cog me-2"></i>Admin Panel
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                       href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box me-1"></i>Products
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                       href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags me-1"></i>Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                       href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart me-1"></i>Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}" target="_blank">
                        <i class="fas fa-external-link-alt me-1"></i>View Store
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    #adminNav .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        padding: 0.5rem 1rem;
        margin: 0 0.25rem;
        border-radius: 8px;
        transition: all 0.3s;
    }
    
    #adminNav .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: white !important;
    }
    
    #adminNav .nav-link.active {
        background: linear-gradient(135deg, #ec4899, #8b5cf6);
        color: white !important;
        font-weight: 600;
    }
</style>
