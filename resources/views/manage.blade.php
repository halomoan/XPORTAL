@extends('layouts.manage_layout') @section('notification')
<div class="nav-item dropdown show">
    <a
        class="nav-link"
        href="#"
        role="button"
        id="dropdownMenuLink"
        data-toggle="dropdown"
        aria-haspopup="true"
        aria-expanded="false"
    >
        <i class="far fa-bell"></i>
        <span
            class="badge badge-warning navbar-badge"
            >{{ Auth::user()->unreadNotifications()->count() }}</span
        >
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"
            >{{ Auth::user()->unreadNotifications()->count() }}
            Notifications</span
        >
        @if( Auth::user()->unreadNotifications()->where('data->group', '=',
        'MSG')->count() > 0)
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i>
            {{ Auth::user()->unreadNotifications()->where('data->group', '=', 'MSG')->count() }}
            new messages
            <span
                class="float-right text-muted text-sm"
                >{{ \Carbon\Carbon::parse(Auth::user()->unreadNotifications()->where('data->group', '=', 'MSG')->latest('created_at')->first()->created_at)->diffForHumans() }}</span
            >
        </a>
        @endif @if( Auth::user()->unreadNotifications()->where('data->group',
        '=', 'INV')->count() > 0)
        <div class="dropdown-divider"></div>
        <a href="/manage" class="dropdown-item">
            <i class="fas fa-users mr-2"></i
            >{{ Auth::user()->unreadNotifications()->where('data->group', '=', 'INV')->count() }}
            Invoice(s)
            <span class="float-right text-muted text-sm"
                >>{{ \Carbon\Carbon::parse(Auth::user()->unreadNotifications()->where('data->group', '=', 'INV')->latest('created_at')->first()->created_at)->diffForHumans() }}</span
            >
        </a>
        @endif

        <div class="dropdown-divider"></div>
        <a href="/manage" class="dropdown-item dropdown-footer"
            >See All Notifications</a
        >
    </div>
</div>
@endsection
