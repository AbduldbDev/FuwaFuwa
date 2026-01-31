<div class="dropdown">
    <button class="btn position-relative" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fa-regular fa-bell notif-bell"></i>
        @if ($unreadCount > 0)
            <span class="notif-badge"> {{ $unreadCount }}</span>
        @endif
    </button>

    <ul class="dropdown-menu dropdown-menu-end notif-panel" aria-labelledby="notifDropdown" style="min-width: 300px;">
        <div class="notif-header">
            <span>Notifications</span>
            @if ($unreadCount > 0)
                <small class="text-muted">{{ $unreadCount }} new</small>
            @endif
        </div>

        <div class="notif-list">
            @forelse($notifications as $notif)
                <a class="notif-item {{ is_null($notif->read_at) ? 'unread' : 'read' }} text-black"
                    style="text-decoration: none" href="{{ route('notifications.read', $notif->id) }}">
                    <i
                        class="@switch($notif->type)
                                @case('info') fa-solid fa-circle-info  @break
                                @case('warning') fa-solid fa-triangle-exclamation  @break
                                @case('danger') fa-solid fa-circle-exclamation @break
                                @case('success') fa-solid fa-circle-check @break
                                @default fa-solid fa-bell @endswitch"></i>
                    <div>
                        <p>{{ $notif->title }}</p>
                        <small>{{ $notif->message }}</small><br>
                        <small>{{ \Carbon\Carbon::parse($notif->created_at)->diffForHumans(['short' => true, 'parts' => 1]) }}</small>
                    </div>
                </a>
            @empty
                <li class="p-2 text-center text-muted">No notifications</li>
            @endforelse
        </div>

        <div class="notif-footer">
            <a href="{{ route('notifications.index') }}">View all notifications</a>
        </div>
    </ul>
</div>
