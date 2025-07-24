@php
    $notifications = auth()->user()->notifications()->latest()->take(150)->get();
    // dd($notifications);
    // $gsd = auth()->user();
@endphp
<div id="notificationDropdown" class="card shadow" style="display:none; position:absolute; right:12px; top:102px; width:300px; z-index:1000;">
        <div class="card-header bg-primary text-white py-2 px-3">
            Notifications
        </div>
        <div class="list-group list-group-flush notificatin_ul" style="max-height: 30rem; overflow-y: auto;">
              @forelse($notifications as $notification)
            @php
                $data = $notification->data;
                $subject = $data['subject'] ?? 'Notification';
                $body = $data['body'] ?? '';
                $url = $data['url'] ?? null;
            @endphp

            @if($url)
                <a class="list-group-item list-group-item-action {{ is_null($notification->read_at) ? 'bg-light' : '' }}"
                   href="{{  $url}}">
                    <div class="fw-bold">{!! $subject !!}</div>
                    <div class="small text-muted">{!! $body !!}</div>
                    <div class="text-end text-muted small">{{ $notification->created_at->diffForHumans() }}</div>
                </a>
            @else
                <div class="list-group-item {{ is_null($notification->read_at) ? 'bg-light' : '' }}">
                    <div class="fw-bold">{!! $subject !!}</div>
                    <div class="small text-muted">{!! $body !!}</div>
                    <div class="text-end text-muted small">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
            @endif
        @empty
            <div class="list-group-item text-center text-muted">No new notifications.</div>
        @endforelse
            </div>
    </div>
</div>

<!-- Simple Toggle Script -->
<script>
    function toggleNotifications() {
      var dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('show');
        if (dropdown.classList.contains('show')) {
            // Mark all notifications as read when the dropdown is shown
            fetch('{{ route('notifications.read.all') }}')
                //.then(response => response.json())
                .then(data => {
                    console.log('All notifications marked as read');
                    const badge = document.getElementById('notification-count');
                    if (badge) {
                    badge.textContent = '0'; // Update the badge count to 0
                }
                })
                .catch(error => console.log('Error: ', error));  

               
    }
} 

// Click outside to close
// document.addEventListener('click', function (event) {
//     const dropdown = document.getElementById('notificationDropdown');
//     if (dropdown && dropdown.classList.contains('show')) {
//         dropdown.classList.remove('show');
//         // dropdown.style.display = 'none';
//     }
// });
</script>