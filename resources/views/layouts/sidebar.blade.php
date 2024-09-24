<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-utensils"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Marketplace Katering</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @if (request()->routeIs('home')) active @endif">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Goods
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    @if (auth()->user()->hasRole('merchant'))
        <li class="nav-item @if (request()->routeIs('merchant.menu.*')) active @endif">
            <a class="nav-link" href="{{ route('merchant.menu.index') }}">
                <i class="fas fa-pizza-slice"></i>
                <span>Menu</span></a>
        </li>
    @endif
    @if (auth()->user()->hasRole('customer'))
        <li class="nav-item @if (request()->routeIs('customer.order.index')) active @endif">
            <a class="nav-link" href="{{ route('customer.order.index') }}">
                <i class="fas fa-shopping-basket"></i>
                <span>Order</span></a>
        </li>
    @endif
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Summary
    </div>

    <!-- Nav Item - Charts -->
    @if (auth()->user()->hasRole('customer'))
        <li class="nav-item @if (request()->routeIs('customer.order.cart')) active @endif">
            <a class="nav-link" href="{{ route('customer.order.cart') }}">
                <i class="fas fa-shopping-cart"></i>
                <span>Cart</span></a>
        </li>
    @endif

    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('invoice.index') }}">
            <i class="fas fa-file-pdf"></i>
            <span>Invoice & Transaction</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
