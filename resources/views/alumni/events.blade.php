@extends('alumni.layout')
@section('title', 'Events')

@push('styles')
<style>
.events-grid {
    display:grid; grid-template-columns:repeat(auto-fill,minmax(320px,1fr)); gap:22px;
}
.event-card {
    background:#fff; border-radius:18px;
    border:1px solid rgba(128,0,32,0.08); overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.07);
    transition:transform 0.3s ease, box-shadow 0.3s ease;
}
.event-card:hover { transform:translateY(-8px); box-shadow:0 14px 40px rgba(128,0,32,0.13); }
.event-card-top {
    background:linear-gradient(135deg,#800020,#5a0016);
    padding:22px; position:relative; overflow:hidden;
}
.event-card-deco { position:absolute; border-radius:50%; background:rgba(255,255,255,0.06); }
.status-badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 11px; border-radius:999px; font-size:11.5px; font-weight:600;
}
.progress-bg { background:rgba(128,0,32,0.08); border-radius:999px; height:7px; overflow:hidden; }
.progress-fill { height:100%; border-radius:999px; background:linear-gradient(90deg,#800020,#c4003a); transition:width 0.6s ease; }

/* Buttons */
.btn-primary {
    background:#800020; color:#fff; border:none; padding:11px 22px;
    border-radius:10px; font-size:14px; font-weight:600; cursor:pointer;
    font-family:'Segoe UI',sans-serif; transition:all 0.25s ease;
    box-shadow:0 4px 14px rgba(128,0,32,0.25);
}
.btn-primary:hover { background:#5a0016; transform:translateY(-2px); box-shadow:0 6px 20px rgba(128,0,32,0.3); }
.btn-outline {
    background:transparent; border:1.5px solid rgba(128,0,32,0.3); color:#800020;
    padding:11px 22px; border-radius:10px; font-size:14px; font-weight:600;
    cursor:pointer; font-family:'Segoe UI',sans-serif; transition:all 0.25s;
}
.btn-outline:hover { background:#fdf0f3; }
.btn-donate {
    background:rgba(253,184,19,0.15); border:1.5px solid rgba(253,184,19,0.4);
    color:#5c3700; padding:11px 16px; border-radius:10px; font-size:13.5px;
    font-weight:600; cursor:pointer; font-family:'Segoe UI',sans-serif; transition:all 0.25s;
}
.btn-donate:hover { background:rgba(253,184,19,0.28); }

/* Modal */
.modal-overlay { display:none; position:fixed; inset:0; z-index:2000; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; padding:16px; }
.modal-overlay.open { display:flex; }
.modal-box { background:#fff; border-radius:22px; padding:30px; width:100%; max-width:460px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.18); }
.field-label { font-size:12.5px; font-weight:600; color:#800020; text-transform:uppercase; letter-spacing:0.6px; margin-bottom:7px; display:block; }
.field-input { width:100%; padding:11px 15px; border:1.5px solid rgba(128,0,32,0.18); border-radius:10px; background:#f8f8f8; font-size:14px; color:#1a1a1a; outline:none; font-family:'Segoe UI',sans-serif; transition:border-color 0.2s,background 0.2s; box-sizing:border-box; }
.field-input:focus { border-color:#800020; background:#fff; }

@media (max-width:768px) {
    .events-grid { grid-template-columns:1fr; gap:16px; }
    .page-header-row { flex-direction:column !important; align-items:flex-start !important; gap:10px; }
    .modal-box { padding:22px 18px; }
}
</style>
@endpush

@section('content')
<div class="page-header-row" style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:12px;">
    <div>
        <h1 style="font-size:28px;font-weight:800;color:#1a1a1a;margin:0 0 5px;font-family:'Georgia',serif;">Events</h1>
        <p style="color:#717182;font-size:14px;margin:0;">Browse and join upcoming alumni events</p>
    </div>
</div>

<div class="events-grid">
    @forelse($events as $event)
    @php
        $attendeeCount = $event->attendees->count();
        $isAttending = $event->attendees->contains('user_id', auth()->id());
        $totalDonations = $event->donations->sum('amount');
        $budget = $event->allocated_budget ?? 0;
        $progress = $budget > 0 ? min(100, ($totalDonations / $budget) * 100) : 0;
        $statusMap = ['upcoming'=>['bg'=>'rgba(253,184,19,0.22)','color'=>'#b8860b'],'ongoing'=>['bg'=>'rgba(34,197,94,0.2)','color'=>'#15803d'],'completed'=>['bg'=>'rgba(255,255,255,0.15)','color'=>'rgba(255,255,255,0.75)'],'cancelled'=>['bg'=>'rgba(239,68,68,0.22)','color'=>'#dc2626']];
        $sc = $statusMap[$event->status] ?? $statusMap['upcoming'];
    @endphp
    <div class="event-card">
        <div class="event-card-top">
            <div class="event-card-deco" style="width:100px;height:100px;top:-30px;right:-30px;"></div>
            <div class="event-card-deco" style="width:55px;height:55px;bottom:-15px;left:20px;opacity:0.5;"></div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start;position:relative;">
                <div style="flex:1;min-width:0;padding-right:12px;">
                    <h3 style="font-size:16.5px;font-weight:700;color:#fff;margin:0 0 7px;line-height:1.3;font-family:'Georgia',serif;">{{ $event->title }}</h3>
                    <div style="font-size:12.5px;color:rgba(255,255,255,0.75);">
                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }} · {{ \Carbon\Carbon::parse($event->event_time)->format('h:i A') }}
                    </div>
                </div>
                <span class="status-badge" style="background:{{ $sc['bg'] }};color:{{ $sc['color'] }};flex-shrink:0;">{{ ucfirst($event->status) }}</span>
            </div>
        </div>

        <div style="padding:20px 22px;">
            @if($event->description)
            <p style="font-size:13.5px;color:#717182;margin:0 0 16px;line-height:1.65;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $event->description }}</p>
            @endif

            <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:18px;">
                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#717182;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    {{ $event->location }}
                </div>
                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#717182;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    {{ $attendeeCount }} attending
                </div>
            </div>

            @if($budget > 0)
            <div style="margin-bottom:18px;">
                <div style="display:flex;justify-content:space-between;font-size:12px;color:#717182;margin-bottom:6px;">
                    <span>Donations</span>
                    <span style="font-weight:600;color:#1a1a1a;">₱{{ number_format($totalDonations,2) }} / ₱{{ number_format($budget,2) }}</span>
                </div>
                <div class="progress-bg"><div class="progress-fill" style="width:{{ $progress }}%;"></div></div>
            </div>
            @endif

            <div style="display:flex;gap:9px;flex-wrap:wrap;">
                @if($event->status === 'upcoming' || $event->status === 'ongoing')
                    @if($isAttending)
                        <form method="POST" action="{{ route('alumni.events.cancel-rsvp',$event) }}" style="flex:1;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-outline" style="width:100%;">Cancel RSVP</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('alumni.events.rsvp',$event) }}" style="flex:1;">
                            @csrf
                            <button type="submit" class="btn-primary" style="width:100%;">RSVP Now</button>
                        </form>
                    @endif
                    <button onclick="openDonateModal({{ $event->id }},'{{ addslashes($event->title) }}')" class="btn-donate">💛 Donate</button>
                @else
                    <span style="font-size:13px;color:#717182;padding:11px 0;">{{ ucfirst($event->status) }}</span>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:70px 20px;color:#717182;">
        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#d0bcc2" stroke-width="1.3" style="margin:0 auto 14px;display:block;"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        No events available right now.
    </div>
    @endforelse
</div>

{{-- Donate Modal --}}
<div class="modal-overlay" id="donateModal" onclick="closeModalOnOverlay(event,'donateModal')">
    <div class="modal-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 style="font-size:19px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Donate to Event</h3>
            <button onclick="closeModal('donateModal')" style="background:none;border:none;cursor:pointer;padding:4px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#717182" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <p style="font-size:14px;color:#717182;margin:0 0 22px;" id="donateEventName"></p>
        <form method="POST" id="donateForm">
            @csrf
            <div style="margin-bottom:16px;">
                <label class="field-label">Amount (₱)</label>
                <input type="number" name="amount" class="field-input" placeholder="e.g. 500" min="1" step="0.01" required>
            </div>
            <div style="margin-bottom:22px;">
                <label class="field-label">Note (optional)</label>
                <input type="text" name="note" class="field-input" placeholder="Add a message...">
            </div>
            <div style="display:flex;gap:10px;">
                <button type="button" onclick="closeModal('donateModal')" class="btn-outline" style="flex:1;">Cancel</button>
                <button type="submit" class="btn-primary" style="flex:1;">Send Donation</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openDonateModal(id,title) {
    document.getElementById('donateEventName').textContent = title;
    document.getElementById('donateForm').action='/alumni/events/'+id+'/donate';
    openModal('donateModal');
}
function openModal(id){ document.getElementById(id).classList.add('open'); document.body.style.overflow='hidden'; }
function closeModal(id){ document.getElementById(id).classList.remove('open'); document.body.style.overflow=''; }
function closeModalOnOverlay(e,id){ if(e.target.id===id) closeModal(id); }
</script>
@endpush