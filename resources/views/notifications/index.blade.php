<x-app-layout>
  <x-slot name="header">Mes Notifications</x-slot>

  <div class="card">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; padding-bottom:14px; border-bottom:2px solid #f1f5f9">
      <h2 style="font-size:1rem; font-weight:700; color:var(--text-dark)">🔔 Toutes mes notifications</h2>
      <span class="badge badge-blue">{{ $notifications->count() }} total</span>
    </div>

    @forelse($notifications as $notif)
    <div style="display:flex; gap:14px; padding:16px; border-radius:12px; margin-bottom:8px; background:{{ $notif->statut == 'non_lu' ? '#f0f4ff' : '#fafafa' }}; border:1px solid {{ $notif->statut == 'non_lu' ? '#c7d2fe' : '#f1f5f9' }}">
      <div style="font-size:1.5rem; flex-shrink:0">
        @if($notif->type == 'inscription') 🎉
        @elseif($notif->type == 'aide') 🆘
        @elseif($notif->type == 'remboursement') 💸
        @elseif($notif->type == 'groupe') 📢
        @elseif($notif->type == 'retard') ⚠️
        @else 🔔
        @endif
      </div>
      <div style="flex:1">
        <div style="font-size:0.875rem; color:var(--text-dark); font-weight:{{ $notif->statut == 'non_lu' ? '600' : '400' }}">
          {{ $notif->message }}
        </div>
        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:4px">
          {{ $notif->created_at->diffForHumans() }}
        </div>
      </div>
      @if($notif->statut == 'non_lu')
      <span class="badge badge-blue" style="align-self:center; flex-shrink:0">Nouveau</span>
      @endif
    </div>
    @empty
    <div style="text-align:center; color:var(--text-muted); padding:48px">
      <div style="font-size:3rem; margin-bottom:12px">🔔</div>
      <div>Aucune notification pour le moment.</div>
    </div>
    @endforelse
  </div>
</x-app-layout>