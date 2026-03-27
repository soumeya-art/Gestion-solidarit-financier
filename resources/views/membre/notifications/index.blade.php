<x-app-layout>
    <x-slot name="header">Mes Notifications</x-slot>

    <div class="card">
        <h2 class="section-title">🔔 Liste des notifications</h2>
        @forelse($notifications as $notification)
        <div style="display:flex; justify-content:space-between; align-items:center; padding:16px; border-bottom:1px solid #f0f4f3; background:{{ $notification->statut == 'non_lu' ? '#fdf8e8' : 'white' }}; border-radius:8px; margin-bottom:8px">
            <div>
                <p style="font-size:0.9rem; color:var(--text)">{{ $notification->message }}</p>
                <p style="font-size:0.75rem; color:var(--muted); margin-top:4px">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
            @if($notification->statut == 'non_lu')
            <a href="/notifications/{{ $notification->id }}/lu" class="btn btn-primary" style="padding:6px 14px; font-size:0.8rem">
                Marquer lu
            </a>
            @else
            <span class="badge badge-success">✅ Lu</span>
            @endif
        </div>
        @empty
        <p style="color:var(--muted); text-align:center; padding:32px">Aucune notification.</p>
        @endforelse
    </div>
</x-app-layout>