<li class="nav-main-item">
    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.dashboard.') !== false ? 'active' : '' }}"
        href="{{ route('admin.dashboard.index') }}">
        <i class="nav-main-link-icon si si-speedometer"></i>
        <span class="nav-main-link-name">Dashboard</span>
    </a>
</li>

@include('layouts.parts.sidebar_components.admin.pengaturan_user')
