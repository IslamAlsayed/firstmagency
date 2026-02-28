<aside class="sidebar {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="sidebar-logo">
        <h4>🎛️ Dashboard</h4>
    </div>

    <ul class="nav-menu">
        <!-- Home Dashboard -->
        <li>
            <a href="{{ route('dashboard.index') }}" class="{{ request()->routeIs('dashboard.index') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                <span>{{ __('dashboard.home') ?? 'الرئيسية' }}</span>
            </a>
        </li>

        <!-- Content Management (جميع الأدوار) -->
        <li>
            <a href="{{ route('dashboard.content') }}" class="{{ request()->routeIs('dashboard.content*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i>
                <span>{{ __('dashboard.content') ?? 'المحتوى' }}</span>
            </a>
        </li>

        <!-- Settings (Admin + Super Admin فقط) -->
        @if (auth()->user()->canManageSettings())
            <li>
                <a href="{{ route('dashboard.settings') }}" class="{{ request()->routeIs('dashboard.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>{{ __('dashboard.settings') ?? 'الإعدادات' }}</span>
                </a>
            </li>
        @endif

        <!-- Sections (Admin + Super Admin فقط) -->
        @if (auth()->user()->canManageSections())
            <li>
                <a href="{{ route('dashboard.sections') }}" class="{{ request()->routeIs('dashboard.sections*') ? 'active' : '' }}">
                    <i class="fas fa-th"></i>
                    <span>{{ __('dashboard.sections') ?? 'الأقسام' }}</span>
                </a>
            </li>
        @endif

        <!-- Revisions (Admin + Super Admin فقط) -->
        @if (auth()->user()->canViewAllRevisions())
            <li>
                <a href="{{ route('dashboard.revisions') }}" class="{{ request()->routeIs('dashboard.revisions*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i>
                    <span>{{ __('dashboard.revisions') ?? 'المراجعات' }}</span>
                </a>
            </li>
        @endif

        <!-- Users Management (Super Admin فقط) -->
        @if (auth()->user()->canManageUsers())
            <li>
                <a href="{{ route('dashboard.users.index') }}" class="{{ request()->routeIs('dashboard.users*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>{{ __('dashboard.users') ?? 'المستخدمون' }}</span>
                </a>
            </li>
        @endif

        <!-- Logout -->
        <li style="margin-top: 40px; border-top: 1px solid rgba(255, 255, 255, 0.2); padding-top: 20px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" style="border: none; background: none; padding: 0; width: 100% !important;">
                    <a href="javascript:void(0)" onclick="this.closest('form').submit();"
                        style="color: rgba(255, 255, 255, 0.8); display: flex; align-items: center; padding: 12px 15px;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>{{ __('auth.logout') ?? 'تسجيل خروج' }}</span>
                    </a>
                </button>
            </form>
        </li>
    </ul>
</aside>
