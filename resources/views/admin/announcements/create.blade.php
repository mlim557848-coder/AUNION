@extends('admin.layout')
@section('page-title', 'Create Announcement')
@section('page-subtitle', 'Write a new announcement')
@section('title', 'Announcements')

@section('content')
<div style="padding: 40px 48px 60px; max-width: 1280px; margin: 0 auto;">

    {{-- Flash messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 12px 20px; margin-bottom: 24px; font-size: 14px; color: #16a34a; font-family: 'Segoe UI', sans-serif;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Page heading --}}
    <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 32px; gap: 16px; flex-wrap: wrap;">
        <div>
            <h1 style="font-size: 28px; font-weight: 600; color: #1a1a1a; margin: 0 0 6px; font-family: 'Segoe UI', sans-serif;">Announcements</h1>
            <p style="font-size: 15px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Manage announcements visible to alumni.</p>
        </div>
        <button onclick="openCreateModal()"
            style="display: flex; align-items: center; gap: 8px; padding: 11px 22px; font-size: 14px; font-weight: 600; background: #800020; color: #ffffff; border-radius: 12px; border: none; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Announcement
        </button>
    </div>

    {{-- Search + Filter --}}
    <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 20px 28px; margin-bottom: 20px;">
        <form method="GET" action="{{ route('admin.announcements.index') }}" style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <div style="position: relative; flex: 1; min-width: 240px;">
                <svg style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #717182;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title..."
                    style="width: 100%; padding: 10px 14px 10px 42px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif;">
            </div>
            <select name="status" style="padding: 10px 14px; font-size: 14px; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; background: #f8f8f8; color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif;">
                <option value="">All Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>Draft</option>
            </select>
            <button type="submit" style="padding: 10px 22px; font-size: 14px; font-weight: 500; background: #800020; color: #ffffff; border: none; border-radius: 10px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Filter</button>
        </form>
    </div>

    {{-- Announcements list --}}
    <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); overflow: hidden;">

        @forelse($announcements as $announcement)
        <div style="padding: 22px 28px; border-bottom: 1px solid rgba(128,0,32,0.05); display: flex; align-items: flex-start; gap: 20px;">

            {{-- Icon --}}
            <div style="width: 44px; height: 44px; border-radius: 12px; background: rgba(128,0,32,0.07); display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 2px;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.8"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            </div>

            {{-- Content --}}
            <div style="flex: 1; min-width: 0;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px; flex-wrap: wrap;">
                    <p style="font-size: 16px; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $announcement->title }}</p>
                    @if($announcement->is_published)
                        <span style="padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: rgba(128,0,32,0.08); color: #800020; font-family: 'Segoe UI', sans-serif;">Published</span>
                    @else
                        <span style="padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: rgba(253,184,19,0.15); color: #7a5500; font-family: 'Segoe UI', sans-serif;">Draft</span>
                    @endif
                </div>
                <p style="font-size: 14px; color: #717182; margin: 0 0 6px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 600px; font-family: 'Segoe UI', sans-serif;">{{ Str::limit($announcement->body, 120) }}</p>
                <p style="font-size: 12px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">
                    By {{ $announcement->author->name ?? 'Admin' }} ·
                    {{ $announcement->is_published && $announcement->published_at ? $announcement->published_at->format('M d, Y') : $announcement->created_at->format('M d, Y') }}
                </p>
            </div>

            {{-- Actions --}}
            <div style="display: flex; align-items: center; gap: 8px; flex-shrink: 0;">
                {{-- Toggle publish --}}
                <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}">
                    @csrf @method('PUT')
                    <input type="hidden" name="title" value="{{ $announcement->title }}">
                    <input type="hidden" name="body" value="{{ $announcement->body }}">
                    <input type="hidden" name="is_published" value="{{ $announcement->is_published ? 0 : 1 }}">
                    <button type="submit"
                        style="padding: 7px 14px; font-size: 13px; font-weight: 500; background: {{ $announcement->is_published ? 'rgba(253,184,19,0.12)' : 'rgba(128,0,32,0.07)' }}; color: {{ $announcement->is_published ? '#7a5500' : '#800020' }}; border: 1px solid {{ $announcement->is_published ? 'rgba(253,184,19,0.3)' : 'rgba(128,0,32,0.2)' }}; border-radius: 8px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                        {{ $announcement->is_published ? 'Unpublish' : 'Publish' }}
                    </button>
                </form>

                {{-- Edit button — opens modal --}}
                <button onclick="openEditModal(
                    {{ $announcement->id }},
                    {{ json_encode($announcement->title) }},
                    {{ json_encode($announcement->body) }},
                    {{ $announcement->is_published ? 'true' : 'false' }},
                    {{ json_encode($announcement->published_at ? $announcement->published_at->format('M d, Y') : '') }}
                )" style="padding: 7px 14px; font-size: 13px; font-weight: 500; background: #800020; color: #ffffff; border-radius: 8px; border: none; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                    Edit
                </button>

                {{-- Delete --}}
                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?')">
                    @csrf @method('DELETE')
                    <button type="submit" style="padding: 7px 14px; font-size: 13px; font-weight: 500; background: transparent; color: #d4183d; border: 1px solid rgba(212,24,61,0.25); border-radius: 8px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">Delete</button>
                </form>
            </div>

        </div>
        @empty
        <div style="padding: 72px 28px; text-align: center;">
            <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(128,0,32,0.07); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(128,0,32,0.4)" stroke-width="1.5"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/></svg>
            </div>
            <p style="font-size: 15px; font-weight: 500; color: #1a1a1a; margin: 0 0 8px; font-family: 'Segoe UI', sans-serif;">No Announcements Found</p>
            <p style="font-size: 14px; color: #717182; margin: 0 0 20px; font-family: 'Segoe UI', sans-serif;">Get started by creating your first announcement.</p>
            <button onclick="openCreateModal()"
                style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 22px; font-size: 14px; font-weight: 600; background: #800020; color: #ffffff; border-radius: 10px; border: none; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Announcement
            </button>
        </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($announcements->hasPages())
    <div style="margin-top: 24px; display: flex; justify-content: center;">
        {{ $announcements->withQueryString()->links() }}
    </div>
    @endif

</div>

{{-- ═══════════════════════════════════════════
     CREATE MODAL
════════════════════════════════════════════ --}}
<div id="createModal" style="display:none; position:fixed; inset:0; z-index:1000; align-items:center; justify-content:center;">
    {{-- Backdrop --}}
    <div onclick="closeCreateModal()" style="position:absolute; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(3px);"></div>

    {{-- Modal box --}}
    <div style="position:relative; background:#ffffff; border-radius:20px; width:100%; max-width:620px; margin:24px; box-shadow:0 20px 60px rgba(128,0,32,0.18); overflow:hidden; z-index:1;">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#800020 0%,#5a0016 100%); padding:24px 28px; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h2 style="font-size:20px; font-weight:700; color:#ffffff; margin:0 0 4px; font-family:'Segoe UI',sans-serif;">New Announcement</h2>
                <p style="font-size:13px; color:rgba(255,255,255,0.7); margin:0; font-family:'Segoe UI',sans-serif;">Fill in the details below to create an announcement.</p>
            </div>
            <button onclick="closeCreateModal()" style="width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.15); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#fff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.announcements.store') }}" style="padding:28px;">
            @csrf

            {{-- Title --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a1a; margin-bottom:8px; font-family:'Segoe UI',sans-serif;">
                    Title <span style="color:#d4183d;">*</span>
                </label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Enter announcement title..."
                    style="width:100%; padding:11px 16px; font-size:14px; border:1.5px solid rgba(128,0,32,0.15); border-radius:10px; background:#f8f8f8; color:#1a1a1a; outline:none; font-family:'Segoe UI',sans-serif; box-sizing:border-box;"
                    onfocus="this.style.borderColor='rgba(128,0,32,0.45)'; this.style.background='#fff';"
                    onblur="this.style.borderColor='rgba(128,0,32,0.15)'; this.style.background='#f8f8f8';">
                @error('title')
                    <p style="font-size:12px; color:#d4183d; margin:6px 0 0; font-family:'Segoe UI',sans-serif;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Body --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a1a; margin-bottom:8px; font-family:'Segoe UI',sans-serif;">
                    Body <span style="color:#d4183d;">*</span>
                </label>
                <textarea name="body" rows="6" placeholder="Write your announcement here..."
                    style="width:100%; padding:11px 16px; font-size:14px; border:1.5px solid rgba(128,0,32,0.15); border-radius:10px; background:#f8f8f8; color:#1a1a1a; outline:none; font-family:'Segoe UI',sans-serif; resize:vertical; box-sizing:border-box;"
                    onfocus="this.style.borderColor='rgba(128,0,32,0.45)'; this.style.background='#fff';"
                    onblur="this.style.borderColor='rgba(128,0,32,0.15)'; this.style.background='#f8f8f8';">{{ old('body') }}</textarea>
                @error('body')
                    <p style="font-size:12px; color:#d4183d; margin:6px 0 0; font-family:'Segoe UI',sans-serif;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Publish toggle --}}
            <div style="display:flex; align-items:center; gap:12px; padding:14px 16px; background:rgba(128,0,32,0.04); border:1px solid rgba(128,0,32,0.1); border-radius:10px; margin-bottom:24px;">
                <input type="checkbox" name="is_published" id="create_is_published" value="1"
                    style="width:16px; height:16px; accent-color:#800020; cursor:pointer;"
                    {{ old('is_published') ? 'checked' : '' }}>
                <label for="create_is_published" style="font-size:14px; color:#1a1a1a; cursor:pointer; font-family:'Segoe UI',sans-serif;">
                    <span style="font-weight:600;">Publish immediately</span>
                    <span style="color:#717182; font-size:13px;"> — alumni will see this right away</span>
                </label>
            </div>

            {{-- Footer buttons --}}
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeCreateModal()"
                    style="padding:10px 22px; font-size:14px; font-weight:500; background:transparent; color:#717182; border:1.5px solid rgba(128,0,32,0.15); border-radius:10px; cursor:pointer; font-family:'Segoe UI',sans-serif;">
                    Cancel
                </button>
                <button type="submit"
                    style="padding:10px 26px; font-size:14px; font-weight:700; background:#800020; color:#ffffff; border:none; border-radius:10px; cursor:pointer; font-family:'Segoe UI',sans-serif;">
                    Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     EDIT MODAL
════════════════════════════════════════════ --}}
<div id="editModal" style="display:none; position:fixed; inset:0; z-index:1000; align-items:center; justify-content:center;">
    {{-- Backdrop --}}
    <div onclick="closeEditModal()" style="position:absolute; inset:0; background:rgba(0,0,0,0.45); backdrop-filter:blur(3px);"></div>

    {{-- Modal box --}}
    <div style="position:relative; background:#ffffff; border-radius:20px; width:100%; max-width:620px; margin:24px; box-shadow:0 20px 60px rgba(128,0,32,0.18); overflow:hidden; z-index:1;">

        {{-- Header --}}
        <div style="background:linear-gradient(135deg,#800020 0%,#5a0016 100%); padding:24px 28px; display:flex; align-items:center; justify-content:space-between;">
            <div>
                <h2 style="font-size:20px; font-weight:700; color:#ffffff; margin:0 0 4px; font-family:'Segoe UI',sans-serif;">Edit Announcement</h2>
                <p style="font-size:13px; color:rgba(255,255,255,0.7); margin:0; font-family:'Segoe UI',sans-serif;">Update the details below.</p>
            </div>
            <button onclick="closeEditModal()" style="width:36px; height:36px; border-radius:50%; background:rgba(255,255,255,0.15); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; color:#fff;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        {{-- Form --}}
        <form id="editForm" method="POST" action="" style="padding:28px;">
            @csrf @method('PUT')

            {{-- Title --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a1a; margin-bottom:8px; font-family:'Segoe UI',sans-serif;">
                    Title <span style="color:#d4183d;">*</span>
                </label>
                <input type="text" id="editTitle" name="title" placeholder="Enter announcement title..."
                    style="width:100%; padding:11px 16px; font-size:14px; border:1.5px solid rgba(128,0,32,0.15); border-radius:10px; background:#f8f8f8; color:#1a1a1a; outline:none; font-family:'Segoe UI',sans-serif; box-sizing:border-box;"
                    onfocus="this.style.borderColor='rgba(128,0,32,0.45)'; this.style.background='#fff';"
                    onblur="this.style.borderColor='rgba(128,0,32,0.15)'; this.style.background='#f8f8f8';">
            </div>

            {{-- Body --}}
            <div style="margin-bottom:20px;">
                <label style="display:block; font-size:13px; font-weight:600; color:#1a1a1a; margin-bottom:8px; font-family:'Segoe UI',sans-serif;">
                    Body <span style="color:#d4183d;">*</span>
                </label>
                <textarea id="editBody" name="body" rows="6" placeholder="Write your announcement here..."
                    style="width:100%; padding:11px 16px; font-size:14px; border:1.5px solid rgba(128,0,32,0.15); border-radius:10px; background:#f8f8f8; color:#1a1a1a; outline:none; font-family:'Segoe UI',sans-serif; resize:vertical; box-sizing:border-box;"
                    onfocus="this.style.borderColor='rgba(128,0,32,0.45)'; this.style.background='#fff';"
                    onblur="this.style.borderColor='rgba(128,0,32,0.15)'; this.style.background='#f8f8f8';"></textarea>
            </div>

            {{-- Publish toggle --}}
            <div style="display:flex; align-items:center; gap:12px; padding:14px 16px; background:rgba(128,0,32,0.04); border:1px solid rgba(128,0,32,0.1); border-radius:10px; margin-bottom:24px;">
                <input type="checkbox" name="is_published" id="edit_is_published" value="1"
                    style="width:16px; height:16px; accent-color:#800020; cursor:pointer;">
                <label for="edit_is_published" style="font-size:14px; color:#1a1a1a; cursor:pointer; font-family:'Segoe UI',sans-serif;">
                    <span style="font-weight:600;">Published</span>
                    <span id="editPublishedSince" style="color:#717182; font-size:13px;"></span>
                </label>
            </div>

            {{-- Footer buttons --}}
            <div style="display:flex; gap:10px; justify-content:flex-end;">
                <button type="button" onclick="closeEditModal()"
                    style="padding:10px 22px; font-size:14px; font-weight:500; background:transparent; color:#717182; border:1.5px solid rgba(128,0,32,0.15); border-radius:10px; cursor:pointer; font-family:'Segoe UI',sans-serif;">
                    Cancel
                </button>
                <button type="submit"
                    style="padding:10px 26px; font-size:14px; font-weight:700; background:#800020; color:#ffffff; border:none; border-radius:10px; cursor:pointer; font-family:'Segoe UI',sans-serif;">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// ── CREATE MODAL ──
function openCreateModal() {
    const modal = document.getElementById('createModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeCreateModal() {
    document.getElementById('createModal').style.display = 'none';
    document.body.style.overflow = '';
}

// ── EDIT MODAL ──
function openEditModal(id, title, body, isPublished, publishedSince) {
    document.getElementById('editTitle').value     = title;
    document.getElementById('editBody').value      = body;
    document.getElementById('edit_is_published').checked = isPublished;
    document.getElementById('editPublishedSince').textContent = publishedSince
        ? ' — since ' + publishedSince : '';
    document.getElementById('editForm').action =
        '/admin/announcements/' + id;
    const modal = document.getElementById('editModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    document.body.style.overflow = '';
}

// Close on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
    }
});

// Re-open create modal if validation failed on store
@if($errors->any() && !request()->route()->named('admin.announcements.edit'))
    openCreateModal();
@endif
</script>

@endsection