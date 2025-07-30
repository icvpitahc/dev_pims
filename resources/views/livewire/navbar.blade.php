<style>
    .user-initials-placeholder {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.8rem;
    }
</style>
<nav class="main-header navbar navbar-expand navbar-dark navbar-success">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('home') }}" class="nav-link">Home</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <!-- Messages-->
        <li class="nav-item">
            <a href="#" class="nav-link" title="Coming soon" onclick="return false;">
                <i class="far fa-comments" style="font-size: 1.2rem;"></i>
            </a>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell" style="font-size: 1.2rem;"></i>
                @if($unreadNotificationsCount > 0)
                    <span class="badge badge-danger navbar-badge rounded-pill">{{ $unreadNotificationsCount }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notification-dropdown">
                <div class="dropdown-header d-flex justify-content-between align-items-center">
                    <span>{{ $unreadNotificationsCount }} New Notifications</span>
                    <a href="#" wire:click.prevent="markAllAsRead">Mark all as read</a>
                </div>
                <div class="dropdown-divider"></div>
                <div class="notification-list">
                    @forelse($unreadNotifications as $notification)
                        <a href="{{ route('home') }}?post={{ $notification->data['post_id'] }}" class="dropdown-item notification-item" wire:click="markAsRead('{{ $notification->id }}')">
                            <div class="d-flex align-items-center">
                                <div class="notification-icon">
                                    @if($notification->type == 'new_post')
                                        <i class="fas fa-plus-circle text-primary"></i>
                                    @elseif($notification->type == 'new_comment')
                                        <i class="fas fa-comment-dots text-success"></i>
                                    @endif
                                </div>
                                <div class="notification-content">
                                    <p class="mb-0">
                                        @if($notification->type == 'new_post')
                                            <strong>{{ $notification->data['author_name'] }}</strong> created a new post: "{{ Str::limit($notification->data['post_title'], 20) }}"
                                        @elseif($notification->type == 'new_comment')
                                            <strong>{{ $notification->data['commenter_name'] }}</strong> commented on your post: "{{ Str::limit($notification->data['post_title'], 20) }}"
                                        @endif
                                    </p>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-3">
                            <p class="mb-0">No new notifications</p>
                        </div>
                    @endforelse
                </div>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer text-center">View all notifications</a>
            </div>
        </li>
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <i class="nav-icon fas fa-user" style="font-size: 1.2rem;"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header text-center">
                    <div class="user-initials-placeholder mx-auto" style="width: 90px; height: 90px; font-size: 2.5rem; background-color: hsl({{ crc32(Auth::id()) % 360 }}, 50%, 50%);">
                        {{ substr(Auth::user()->first_name, 0, 1) . substr(Auth::user()->last_name, 0, 1) }}
                    </div>
                    <p class="mt-2">
                        {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        <small>Member since {{ Auth::user()->created_at->format('M. Y') }}</small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <a href="#" class="btn btn-default btn-flat"><i class="nav-icon fas fa-user mr-2"></i>Profile</a>
                    <a href="#" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="nav-icon fas fa-sign-out-alt mr-1"></i> 
                       Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
