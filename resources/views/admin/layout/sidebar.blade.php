<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard') }}" class="app-brand-link">
            <img src="{{ asset('admin/assets/img/logo-right.png') }}" alt="" style="width: 8rem; margin: 20px;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item active">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        {{-- @can('departments') --}}
        <!-- Category -->

        {{-- Departments --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Departments</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-buildings"></i>
                <div data-i18n="Departments">Departments</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('departments.index') }}" class="menu-link">
                        <div data-i18n="View">View Departments</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Employment Types --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Employment Types</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-briefcase-alt-2"></i>
                <div data-i18n="Employment Types">Employment Types</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('employment-types.index') }}" class="menu-link">
                        <div data-i18n="View">View Employment Types</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Locations --}}
        {{-- <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Locations</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-map"></i>
                <div data-i18n="Locations">Locations</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('locations.index') }}" class="menu-link">
                        <div data-i18n="View">View Locations</div>
                    </a>
                </li>
            </ul>
        </li> --}}

        {{-- Campuses --}}
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Campuses</span>
        </li>
        <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-building-house"></i>
                <div data-i18n="Campuses">Campuses</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item">
                    <a href="{{ route('campuses.index') }}" class="menu-link">
                        <div data-i18n="View">View Campuses</div>
                    </a>
                </li>
            </ul>
        </li>
        @can('job management')
            {{-- Jobs --}}
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Manage Jobs</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-briefcase"></i>
                    <div data-i18n="Jobs">Manage Jobs</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('jobs.index') }}" class="menu-link">
                            <div data-i18n="View">View Jobs</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        {{-- @endcan --}}

        {{-- @can('products')
            <!-- Products -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Products</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-package"></i>
                    <div data-i18n="Account Settings">Products</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('products') }}" class="menu-link">
                            <div data-i18n="Account">View Product</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan --}}

        {{-- @can('orders')
            <!-- Orders -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Orders</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-cart"></i>
                    <div data-i18n="Account Settings">Orders</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('orders') }}" class="menu-link">
                            <div data-i18n="Account">View Order</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('instructions')
            <!-- Instructions -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Instructions</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-book-content"></i>
                    <div data-i18n="Account Settings">Instructions</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('instructionguides') }}" class="menu-link">
                            <div data-i18n="Account">View Instruction</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('contactmessages')
            <!-- Contact Message -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Contact Message</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-envelope"></i>
                    <div data-i18n="Account Settings">Contact Message</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('contactmessages') }}" class="menu-link">
                            <div data-i18n="Account">View Contact Message</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan --}}

        @can('user management')
            <!-- Users Management -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Users Management</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-user"></i>
                    <div data-i18n="Account Settings">Users Management</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('users.index') }}" class="menu-link">
                            <div data-i18n="Account">View Users</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('role management')
            <!-- Roles Management -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Roles Management</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-shield-quarter"></i>
                    <div data-i18n="Account Settings">Roles Management</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('roles') }}" class="menu-link">
                            <div data-i18n="Account">View Roles</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        @can('permission management')
            <!-- Permissions Management -->
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Permissions Management</span>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-lock-alt"></i>
                    <div data-i18n="Account Settings">Permissions Management</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item">
                        <a href="{{ route('permissions') }}" class="menu-link">
                            <div data-i18n="Account">View Permissions</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endcan

        <li class="menu-item active mt-3">
            <a href="{{ route('cacheclear') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-dlear"></i>
                <div data-i18n="Analytics">Cache Clear</div>
            </a>
        </li>
    </ul>
</aside>
