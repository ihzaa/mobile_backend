@canany(['view Pengaturan_User_Perizinan', 'view Pengaturan_User_User'])
    <li class="nav-main-item {{ strpos(Route::current()->getName(), 'admin.user_config.') !== false ? 'open' : '' }}">
        <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false"
            href="#">
            <i class="nav-main-link-icon fa fa-user-cog"></i>
            <span class="nav-main-link-name">Pengaturan User</span>
        </a>
        <ul class="nav-main-submenu">
            @can('view Pengaturan_User_Perizinan')
                <li class="nav-main-item">
                    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.user_config.permission.') !== false ? 'active' : '' }}"
                        href="{{ route('admin.user_config.permission.index') }}">
                        <span class="nav-main-link-name">Perizinan</span>
                    </a>
                </li>
            @endcan
            @can('view Pengaturan_User_User')
                <li class="nav-main-item">
                    <a class="nav-main-link {{ strpos(Route::current()->getName(), 'admin.user_config.user.') !== false ? 'active' : '' }}"
                        href="{{ route('admin.user_config.user.index') }}">
                        <span class="nav-main-link-name">User</span>
                    </a>
                </li>
            @endcan
        </ul>
    </li>
@endcanany
