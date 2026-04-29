@extends('alumni.layout')
@section('title', 'Announcements')

@push('styles')
<style>
.ann-card {
    background:#fff; border-radius:18px;
    border:1px solid rgba(128,0,32,0.08);
    padding:28px; margin-bottom:18px;
    box-shadow:0 5px 20px rgba(0,0,0,0.06);
    transition:transform 0.3s ease, box-shadow 0.3s ease;
}
.ann-card:hover { transform:translateY(-4px); box-shadow:0 10px 32px rgba(128,0,32,0.1); }
.ann-category {
    display:inline-block; padding:4px 13px; border-radius:999px;
    font-size:11.5px; font-weight:600; background:#fdf0f3;
    color:#800020; margin-bottom:12px;
    border:1px solid rgba(128,0,32,0.12);
}
.ann-meta { display:flex; align-items:center; gap:18px; flex-wrap:wrap; }
.ann-meta span { display:flex; align-items:center; gap:5px; font-size:12px; color:#717182; }
.ann-body-preview {
    display:-webkit-box; -webkit-line-clamp:3;
    -webkit-box-orient:vertical; overflow:hidden;
    font-size:14px; color:#717182; line-height:1.75; margin:0 0 18px;
}

/* Modal */
#ann-modal-overlay {
    display:none; position:fixed; inset:0; z-index:9999;
    background:rgba(0,0,0,0.45);
    align-items:center; justify-content:center;
    padding:16px;
}
#ann-modal-overlay.open { display:flex; }
#ann-modal-box {
    background:#fff; border-radius:20px;
    width:100%; max-width:620px;
    max-height:88vh; overflow-y:auto;
    padding:36px 36px 32px;
    position:relative;
    box-shadow:0 24px 64px rgba(0,0,0,0.18);
    animation:modalIn 0.22s ease;
}
@keyframes modalIn {
    from { transform:translateY(18px); opacity:0; }
    to   { transform:translateY(0);    opacity:1; }
}
#ann-modal-close {
    position:absolute; top:16px; right:16px;
    background:#fdf0f3; border:none; border-radius:50%;
    width:34px; height:34px; cursor:pointer;
    display:flex; align-items:center; justify-content:center;
    color:#800020; transition:background 0.2s;
}
#ann-modal-close:hover { background:#f5d0d8; }

@media (max-width:768px) {
    .ann-card { padding:20px 16px; }
    .ann-meta { gap:10px; }
    .section-header-row { flex-direction:column !important; align-items:flex-start !important; gap:8px; }
    #ann-modal-box { padding:24px 20px 22px; border-radius:16px; }
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:32px;flex-wrap:wrap;gap:12px;" class="section-header-row">
    <div>
        <h1 style="font-size:28px;font-weight:800;color:#1a1a1a;margin:0 0 5px;font-family:'Georgia',serif;">Announcements</h1>
        <p style="color:#717182;font-size:14px;margin:0;">Stay updated with the latest news from Aunion</p>
    </div>
    @if(method_exists($announcements,'total'))
    <div style="background:#fdf0f3;border:1px solid rgba(128,0,32,0.15);border-radius:999px;padding:7px 18px;font-size:13px;font-weight:600;color:#800020;">
        {{ $announcements->total() }} announcements
    </div>
    @endif
</div>

{{-- Cards --}}
@forelse($announcements as $ann)
<div class="ann-card">
    <span class="ann-category">{{ $ann->category }}</span>
    <h2 style="font-size:18px;font-weight:700;color:#1a1a1a;margin:0 0 10px;line-height:1.4;font-family:'Georgia',serif;">
        {{ $ann->title }}
    </h2>
    <p class="ann-body-preview">{{ $ann->body }}</p>
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
        <div class="ann-meta">
            @if($ann->author)
            <span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                {{ $ann->author->name }}
            </span>
            @endif
            <span>
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                {{ $ann->published_at ? \Carbon\Carbon::parse($ann->published_at)->format('M d, Y') : 'N/A' }}
            </span>
        </div>
        <button
            onclick="openAnnModal({{ $ann->id }})"
            style="font-size:13px;color:#800020;font-weight:600;background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:4px;padding:0;font-family:'Segoe UI',sans-serif;transition:gap 0.2s;"
            onmouseover="this.style.gap='7px'" onmouseout="this.style.gap='4px'">
            See more
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
    </div>
</div>
@empty
<div style="text-align:center;padding:70px 20px;color:#717182;">
    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#d0bcc2" stroke-width="1.3" style="margin:0 auto 14px;display:block;"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
    No announcements yet.
</div>
@endforelse

@if(method_exists($announcements,'hasPages') && $announcements->hasPages())
<div style="margin-top:28px;display:flex;justify-content:center;">{{ $announcements->links() }}</div>
@endif

{{-- ===== MODAL ===== --}}
<div id="ann-modal-overlay" onclick="closeAnnModalOnOverlay(event)">
    <div id="ann-modal-box">
        <button id="ann-modal-close" onclick="closeAnnModal()" aria-label="Close">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>

        {{-- Category + Date row --}}
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:16px;flex-wrap:wrap;">
            <span id="modal-category" class="ann-category" style="margin-bottom:0;"></span>
            <span id="modal-date" style="font-size:12px;color:#717182;display:flex;align-items:center;gap:4px;">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <span id="modal-date-text"></span>
            </span>
        </div>

        <h2 id="modal-title" style="font-size:22px;font-weight:700;color:#1a1a1a;margin:0 0 6px;line-height:1.35;font-family:'Georgia',serif;padding-right:30px;"></h2>

        <p id="modal-author" style="font-size:13px;color:#717182;margin:0 0 20px;display:flex;align-items:center;gap:5px;">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            <span id="modal-author-name"></span>
        </p>

        <div style="height:1px;background:rgba(128,0,32,0.08);margin-bottom:20px;"></div>

        <p id="modal-body" style="font-size:15px;color:#1a1a1a;line-height:1.8;margin:0;white-space:pre-wrap;"></p>
    </div>
</div>

{{-- Announcement data for JS --}}
<script>
const annData = {
    @foreach($announcements as $ann)
    {{ $ann->id }}: {
        title:    @json($ann->title),
        body:     @json($ann->body),
        category: @json($ann->category),
        author:   @json($ann->author ? $ann->author->name : null),
        date:     @json($ann->published_at ? \Carbon\Carbon::parse($ann->published_at)->format('M d, Y') : 'N/A'),
    },
    @endforeach
};

function openAnnModal(id) {
    const a = annData[id];
    if (!a) return;
    document.getElementById('modal-title').textContent      = a.title;
    document.getElementById('modal-body').textContent       = a.body;
    document.getElementById('modal-category').textContent   = a.category;
    document.getElementById('modal-date-text').textContent  = a.date;
    document.getElementById('modal-author-name').textContent = a.author ?? '';
    document.getElementById('modal-author').style.display   = a.author ? 'flex' : 'none';
    document.getElementById('ann-modal-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeAnnModal() {
    document.getElementById('ann-modal-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

function closeAnnModalOnOverlay(e) {
    if (e.target === document.getElementById('ann-modal-overlay')) closeAnnModal();
}

document.addEventListener('keydown', e => { if (e.key === 'Escape') closeAnnModal(); });
</script>

@endsection