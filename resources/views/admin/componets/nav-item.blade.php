@php
    $isActive = collect($options)->pluck('route')->contains(function($r) {
        return Route::is($r);
    });
@endphp

<li class="nav-item {{ $isActive ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ $isActive ? 'active' : '' }}">
        <i class="nav-icon {{$icon}}"></i>
        <p>
            {{$label}}
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: {{ $isActive ? 'block' : 'none' }}">
        @foreach ($options as $option)
            <li class="nav-item">
                <a href="{{ route($option['route']) }}" class="nav-link {{ Route::is($option['route']) ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ $option['label'] }}</p>
                </a>
            </li>
        @endforeach
    </ul>
</li>
