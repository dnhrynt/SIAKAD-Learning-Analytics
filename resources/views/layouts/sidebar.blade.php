@php
    use App\Http\Controllers\SidebarController;
    $menus = SidebarController::menu();
@endphp

<aside class="app-sidebar border-end vh-100 p-3" style="width: 260px;">
    <ul class="nav flex-column gap-1">
        @foreach ($menus as $menu)
            <li class="nav-item">
                <a href="{{ route($menu['route']) }}"
                   class="nav-link d-flex align-items-center gap-2
                   {{ request()->routeIs($menu['route']) ? 'active fw-bold' : '' }}">
                    
                    <i class="bi {{ $menu['icon'] }}"></i>
                    <span>{{ $menu['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</aside>

