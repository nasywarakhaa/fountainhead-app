<aside class="main-sidebar elevation-4" style="background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center">
        <img src="{{ asset('images/logo.png') }}"
            alt="Fountainhead Logo"
            class="brand-image img-rounded elevation-3">
        <span class="brand-text font-semibold text-gray text-lg tracking-wide whitespace-nowrap">Fountainhead</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
    <!-- User Panel -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="image">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=f39c12&color=fff"
                class="img-circle elevation-2" alt="User Image" style="border: 2px solid #f39c12;">
        </div>
        <div class="info">
            <a href="#" class="d-block" style="color: #fff; font-weight: 500;">{{ Auth::user()->name ?? 'Admin' }}</a>
            <span style="color: rgba(255,255,255,0.6); font-size: 0.8rem;">
            <i class="fas fa-circle text-success" style="font-size: 0.5rem;"></i> Online
            </span>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

        <!-- Dashboard -->
    @role('admin|operator')
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.dashboard') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.dashboard') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-tachometer-alt" style="color: #f39c12;"></i>
                <p style="font-weight: 500;">Dashboard</p>
            </a>
        </li>

        <!-- Coliving -->
        <li class="nav-item {{ request()->routeIs('admin.coliving-*') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ request()->routeIs('admin.coliving-*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.coliving-*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.coliving-*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-bed" style="color: #3498db;"></i>
                <p style="font-weight: 500;">
                Coliving
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 10px;">
                @role('operator')
                <li class="nav-item">
                <a href="{{ route('admin.coliving-rooms.index') }}"
                    class="nav-link {{ request()->routeIs('admin.coliving-rooms.*') ? 'active' : '' }}"
                    style="color: {{ request()->routeIs('admin.coliving-rooms.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                            padding-left: 40px;">
                    <i class="far fa-circle nav-icon" style="font-size: 0.6rem; color: #3498db;"></i>
                    <p>Rooms</p>
                </a>
                </li>
            @endrole
            @role('admin|operator')
            <li class="nav-item">
                <a href="{{ route('admin.coliving-bookings.index') }}"
                    class="nav-link {{ request()->routeIs('admin.coliving-bookings.*') ? 'active' : '' }}"
                    style="color: {{ request()->routeIs('admin.coliving-bookings.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                            padding-left: 40px;">
                    <i class="far fa-circle nav-icon" style="font-size: 0.6rem; color: #3498db;"></i>
                    <p>Bookings</p>
                </a>
                </li>
            </ul>
            @endrole
        </li>

        <!-- Cafe & Events -->
        <li class="nav-item {{ request()->routeIs('admin.cafe-*') ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ request()->routeIs('admin.cafe-*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.cafe-*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.cafe-*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-coffee" style="color: #e67e22;"></i>
                <p style="font-weight: 500;">
                Cafe & Events
                <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview" style="padding-left: 10px;">
            <li class="nav-item">
                <a href="{{ route('admin.cafe-bookings.index') }}"
                    class="nav-link {{ request()->routeIs('admin.cafe-bookings.*') ? 'active' : '' }}"
                    style="color: {{ request()->routeIs('admin.cafe-bookings.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                            padding-left: 40px;">
                    <i class="far fa-circle nav-icon" style="font-size: 0.6rem; color: #e67e22;"></i>
                    <p>Event Bookings</p>
                </a>
            </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.contact-messages.index') }}" class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.contact-messages.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.contact-messages.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-envelope" style="color: #f39c12;"></i>
                <p>Contact Messages</p>
            </a>
        </li>
    @endrole
    @role('operator')
        <!-- Homepage -->
        <li class="nav-item">
            <a href="{{ route('admin.homepage.index') }}"
                class="nav-link {{ request()->routeIs('admin.homepage.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.homepage.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.homepage.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-home" style="color: #9b59b6;"></i>
                <p style="font-weight: 500;">Homepage</p>
            </a>
        </li>

        <!-- Content Management -->
        <li class="nav-header" style="color: rgba(255,255,255,0.5); margin-top: 15px; padding-left: 15px;">CONTENT</li>
        {{-- <li class="nav-item">
            <a href="{{ route('admin.hero-sliders.index') }}"
                class="nav-link {{ request()->routeIs('admin.hero-sliders.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.hero-sliders.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.hero-sliders.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-image" style="color: #9b59b6;"></i>
                <p style="font-weight: 500;">Homepage Banner</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('admin.features.index') }}" class="nav-link {{ request()->routeIs('admin.features.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.features.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.features.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-star" style="color: #f1c40f;"></i>
                <p>Features</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.testimonials.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.testimonials.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-quote-left" style="color: #2ecc71;"></i>
                <p>Testimonials</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.galleries.index') }}" class="nav-link {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.galleries.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.galleries.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-images" style="color: #1abc9c;"></i>
                <p>Gallery</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.faqs.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.faqs.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-question-circle" style="color: #e74c3c;"></i>
                <p>FAQs</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.contact-messages.index') }}" class="nav-link {{ request()->routeIs('admin.contact-messages.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.contact-messages.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.contact-messages.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-envelope" style="color: #f39c12;"></i>
                <p>Contact Messages</p>
            </a>
        </li>

        <!-- Settings -->
        <li class="nav-header" style="color: rgba(255,255,255,0.5); margin-top: 15px; padding-left: 15px;">SETTINGS</li>

        {{-- <li class="nav-item">
            <a href="{{ route('admin.site-settings.index') }}" class="nav-link {{ request()->routeIs('admin.site-settings.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.site-settings.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.site-settings.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-cogs" style="color: #95a5a6;"></i>
                <p>Site Settings</p>
            </a>
        </li> --}}
    @endrole
        <li class="nav-item">
            <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
                style="color: {{ request()->routeIs('admin.profile.*') ? '#fff' : 'rgba(255,255,255,0.7)' }};
                        background: {{ request()->routeIs('admin.profile.*') ? 'rgba(243,156,18,0.2)' : 'transparent' }};
                        border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-user-cog" style="color: #bdc3c7;"></i>
                <p>Profile</p>
            </a>
        </li>
        <!-- Logout -->
        <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="nav-link" style="color: rgba(255,255,255,0.7); border-radius: 8px; margin: 4px 8px;">
                <i class="nav-icon fas fa-sign-out-alt" style="color: #e74c3c;"></i>
                <p>Logout</p>
                </a>
            </form>
        </li>

        </ul>
        </nav>
    </div>
</aside>
