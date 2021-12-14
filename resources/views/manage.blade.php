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
        <span class="badge badge-warning navbar-badge">15</span>
    </a>

    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header"
            >{{ Auth::user()->unreadNotifications()->count() }}
            Notifications</span
        >
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i>
            {{ Auth::user()->unreadNotifications()->where('data->group', '=', 'MSG')->count() }}
            new messages
            <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i
            >{{ Auth::user()->unreadNotifications()->where('data->group', '=', 'ROLES')->count() }}
            new roles created
            <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer"
            >See All Notifications</a
        >
    </div>
</div>
@endsection
