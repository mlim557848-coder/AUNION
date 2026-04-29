@extends('alumni.layout')
@section('title', 'Edit Profile')

@push('styles')
<style>
* { box-sizing: border-box; }

/* ── Header Banner ── */
.edit-header {
    background: linear-gradient(135deg, #800020 0%, #5a0016 100%);
    padding: 36px 48px 44px;
    position: relative; overflow: hidden;
}
.edit-header-inner {
    max-width: 1280px; margin: 0 auto;
    display: flex; align-items: center;
    justify-content: space-between;
    position: relative; z-index: 1;
    flex-wrap: wrap; gap: 16px;
}
.edit-header-left {
    display: flex; align-items: center; gap: 20px;
}
.edit-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.25);
    flex-shrink: 0; overflow: hidden;
    background: #FDB813;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px; font-weight: 700; color: #5c3700;
    font-family: 'Segoe UI', sans-serif;
}
.edit-avatar img { width: 100%; height: 100%; object-fit: cover; }

/* ── Form Layout ── */
.edit-body {
    padding: 40px 48px 60px;
    max-width: 1280px; margin: 0 auto;
    font-family: 'Segoe UI', sans-serif;
}
.edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
}
.edit-col {
    display: flex; flex-direction: column; gap: 24px;
}

/* ── Cards ── */
.edit-card {
    background: #fff; border-radius: 16px; overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.07);
    border: 1px solid rgba(128,0,32,0.06);
}
.edit-card-header {
    padding: 20px 28px 16px;
    border-bottom: 1px solid rgba(128,0,32,0.07);
    display: flex; align-items: center; gap: 12px;
}
.edit-card-icon {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.edit-card-body {
    padding: 24px 28px;
    display: flex; flex-direction: column; gap: 20px;
}

/* ── Form Fields ── */
.field-label {
    display: block; font-size: 12px; font-weight: 600;
    color: #800020; text-transform: uppercase;
    letter-spacing: 0.7px; margin-bottom: 8px;
}
.field-hint {
    font-size: 12px; color: #717182; margin: 0 0 8px;
}
.field-input, .field-textarea {
    width: 100%; padding: 12px 16px;
    border: 1.5px solid rgba(128,0,32,0.15);
    border-radius: 10px; font-size: 14px; color: #1a1a1a;
    background: #f8f8f8; font-family: 'Segoe UI', sans-serif;
    outline: none; transition: border-color 0.15s, background 0.15s;
}
.field-input:focus, .field-textarea:focus {
    border-color: #800020; background: #fff;
}
.field-textarea { resize: vertical; line-height: 1.6; }
.two-col-fields {
    display: grid; grid-template-columns: 1fr 1fr; gap: 16px;
}

/* ── Photo Upload ── */
.photo-upload-row {
    display: flex; align-items: center; gap: 20px; margin-bottom: 16px;
}
.photo-circle {
    width: 80px; height: 80px; border-radius: 50%;
    overflow: hidden; border: 3px solid rgba(128,0,32,0.15);
    flex-shrink: 0; background: #f8f8f8;
    display: flex; align-items: center; justify-content: center;
}

/* ── Save Card ── */
.save-card-body {
    padding: 24px 28px;
}
.btn-save {
    width: 100%; padding: 14px; background: #800020; color: #fff;
    border: none; border-radius: 10px; font-size: 15px; font-weight: 700;
    font-family: 'Segoe UI', sans-serif; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 10px;
    box-shadow: 0 4px 15px rgba(128,0,32,0.3);
    transition: background 0.15s; margin-bottom: 12px;
}
.btn-save:hover { background: #5a0016; }
.btn-cancel {
    width: 100%; padding: 13px; background: #fff; color: #800020;
    border: 1.5px solid rgba(128,0,32,0.2); border-radius: 10px;
    font-size: 15px; font-weight: 600; font-family: 'Segoe UI', sans-serif;
    text-decoration: none; display: flex;
    align-items: center; justify-content: center; gap: 10px;
}

/* ── Alerts ── */
.alert-success {
    background: rgba(128,0,32,0.06); border: 1.5px solid rgba(128,0,32,0.2);
    border-radius: 12px; padding: 14px 20px; margin-bottom: 28px;
    display: flex; align-items: center; gap: 12px;
}
.alert-error {
    background: rgba(220,38,38,0.05); border: 1.5px solid rgba(220,38,38,0.2);
    border-radius: 12px; padding: 14px 20px; margin-bottom: 28px;
}

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .edit-grid { grid-template-columns: 1fr; }
    /* On mobile, move save card to bottom naturally */
}
@media (max-width: 768px) {
    .edit-header { padding: 24px 16px 28px; }
    .edit-header-inner { flex-direction: column; align-items: flex-start; gap: 14px; }
    .edit-header-left { gap: 14px; }
    .edit-avatar { width: 56px; height: 56px; font-size: 20px; }
    .edit-header h1 { font-size: 1.3rem !important; }
    .back-btn { width: 100%; justify-content: center; }

    .edit-body { padding: 20px 16px 40px; }
    .edit-card-header { padding: 16px 18px 12px; }
    .edit-card-body { padding: 18px 18px; gap: 16px; }
    .save-card-body { padding: 18px; }
    .two-col-fields { grid-template-columns: 1fr; gap: 16px; }

    .photo-upload-row { flex-direction: column; align-items: flex-start; gap: 14px; }
    .photo-circle { width: 72px; height: 72px; }
}
@media (max-width: 480px) {
    .edit-header-left { flex-direction: column; align-items: flex-start; }
}
</style>
@endpush

@section('content')

{{-- ── PAGE HEADER BANNER ── --}}
<div class="edit-header" style="margin: -40px -48px 0; position: relative;">
    {{-- Decorative circles --}}
    <div style="position:absolute;top:-60px;right:-60px;width:280px;height:280px;border-radius:50%;background:rgba(253,184,19,0.08);"></div>
    <div style="position:absolute;bottom:-60px;right:220px;width:160px;height:160px;border-radius:50%;background:rgba(255,255,255,0.04);"></div>

    <div class="edit-header-inner">
        <div class="edit-header-left">
            {{-- Avatar --}}
            <div class="edit-avatar">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('profile_photos/' . auth()->user()->profile_photo) }}" alt="{{ auth()->user()->name }}">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(auth()->user()->name, ' ') ?: ' ', 1, 1)) }}
                @endif
            </div>
            <div>
                <div style="display:inline-flex;align-items:center;gap:7px;background:rgba(253,184,19,0.18);border:1px solid rgba(253,184,19,0.35);border-radius:50px;padding:4px 13px;margin-bottom:8px;">
                    <div style="width:6px;height:6px;border-radius:50%;background:#FDB813;"></div>
                    <span style="color:#FDB813;font-size:12px;font-weight:600;font-family:'Segoe UI',sans-serif;">Editing Profile</span>
                </div>
                <h1 class="edit-header" style="font-size:1.8rem;font-weight:700;color:#fff;margin:0;font-family:'Georgia',serif;background:none;padding:0;">{{ auth()->user()->name }}</h1>
                <p style="color:rgba(255,255,255,0.65);font-size:13px;margin:4px 0 0;font-family:'Segoe UI',sans-serif;">Keep your information up to date for the alumni community.</p>
            </div>
        </div>
        <a href="{{ route('alumni.profile') }}" class="back-btn" style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.12);color:#fff;padding:10px 20px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px;font-family:'Segoe UI',sans-serif;border:1.5px solid rgba(255,255,255,0.25);white-space:nowrap;">
            <svg width="15" height="15" fill="none" stroke="#fff" stroke-width="2.2" viewBox="0 0 24 24"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Back to Profile
        </a>
    </div>
</div>

{{-- ── FORM BODY ── --}}
<div class="edit-body" style="margin-top: 0;">

    @if(session('success'))
    <div class="alert-success">
        <div style="width:32px;height:32px;background:#800020;border-radius:50%;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="15" height="15" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        <p style="color:#800020;font-size:14px;font-weight:600;margin:0;">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="alert-error">
        <p style="color:#b91c1c;font-size:13px;font-weight:700;margin:0 0 8px;">Please fix the following errors:</p>
        @foreach($errors->all() as $error)
        <p style="color:#b91c1c;font-size:13px;margin:0 0 4px;">• {{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ route('alumni.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="edit-grid">

            {{-- ══ LEFT COLUMN ══ --}}
            <div class="edit-col">

                {{-- Personal Information --}}
                <div class="edit-card">
                    <div class="edit-card-header">
                        <div class="edit-card-icon" style="background:#800020;">
                            <svg width="17" height="17" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <h3 style="font-size:15px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Personal Information</h3>
                    </div>
                    <div class="edit-card-body">
                        <div>
                            <label class="field-label">Full Name</label>
                            <input type="text" name="name" class="field-input"
                                value="{{ old('name', auth()->user()->name) }}"
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                        </div>
                        <div>
                            <label class="field-label">Student ID</label>
                            <input type="text" name="student_id" class="field-input"
                                value="{{ old('student_id', auth()->user()->student_id) }}"
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                        </div>
                        <div class="two-col-fields">
                            <div>
                                <label class="field-label">Batch Year</label>
                                <input type="number" name="batch_year" class="field-input"
                                    value="{{ old('batch_year', auth()->user()->batch_year) }}" placeholder="e.g. 2020"
                                    onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                    onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                            </div>
                            <div>
                                <label class="field-label">Course / Program</label>
                                <input type="text" name="course" class="field-input"
                                    value="{{ old('course', auth()->user()->course) }}" placeholder="e.g. BSCS"
                                    onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                    onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Professional Information --}}
                <div class="edit-card">
                    <div class="edit-card-header">
                        <div class="edit-card-icon" style="background:#FDB813;">
                            <svg width="17" height="17" fill="none" stroke="#5c3700" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                        </div>
                        <h3 style="font-size:15px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Professional Information</h3>
                    </div>
                    <div class="edit-card-body">
                        <div>
                            <label class="field-label">Current Position / Job Title</label>
                            <input type="text" name="current_position" class="field-input"
                                value="{{ old('current_position', auth()->user()->current_position) }}"
                                placeholder="e.g. Software Engineer"
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                        </div>
                        <div>
                            <label class="field-label">Industry</label>
                            <input type="text" name="industry" class="field-input"
                                value="{{ old('industry', auth()->user()->industry) }}"
                                placeholder="e.g. Information Technology"
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                        </div>
                        <div>
                            <label class="field-label">Skills</label>
                            <p class="field-hint">Separate skills with commas — e.g. Laravel, Vue.js, MySQL</p>
                            <textarea name="skills" rows="3" class="field-textarea"
                                placeholder="Laravel, Vue.js, MySQL..."
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">{{ old('skills', is_array(auth()->user()->skills) ? implode(', ', auth()->user()->skills) : auth()->user()->skills) }}</textarea>
                            <div id="skills-preview" style="display:flex;flex-wrap:wrap;gap:8px;margin-top:10px;"></div>
                        </div>
                        <div>
                            <label class="field-label">LinkedIn Profile URL</label>
                            <input type="url" name="linkedin" class="field-input"
                                value="{{ old('linkedin', auth()->user()->linkedin) }}"
                                placeholder="https://linkedin.com/in/yourname"
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                        </div>
                    </div>
                </div>

            </div>{{-- end left col --}}

            {{-- ══ RIGHT COLUMN ══ --}}
            <div class="edit-col">

                {{-- Profile Photo --}}
                <div class="edit-card">
                    <div class="edit-card-header">
                        <div class="edit-card-icon" style="background:#800020;">
                            <svg width="17" height="17" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <h3 style="font-size:15px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Profile Photo</h3>
                    </div>
                    <div class="edit-card-body">
                        <div class="photo-upload-row">
                            <div class="photo-circle">
                                @if(auth()->user()->profile_photo)
                                    <img id="photo-preview" src="{{ asset('profile_photos/' . auth()->user()->profile_photo) }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <span id="photo-initials" style="font-size:26px;font-weight:700;color:#800020;font-family:'Segoe UI',sans-serif;">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}{{ strtoupper(substr(strstr(auth()->user()->name, ' ') ?: ' ', 1, 1)) }}
                                    </span>
                                    <img id="photo-preview" src="" style="width:100%;height:100%;object-fit:cover;display:none;">
                                @endif
                            </div>
                            <div style="flex:1;">
                                <p style="font-size:13px;font-weight:600;color:#1a1a1a;margin:0 0 4px;">Upload a new photo</p>
                                <p style="font-size:12px;color:#717182;margin:0 0 12px;">JPG, PNG, GIF or WEBP. Max 2MB.</p>
                                <label for="profile_photo_input" style="display:inline-flex;align-items:center;gap:8px;background:#800020;color:#fff;padding:9px 18px;border-radius:8px;cursor:pointer;font-size:13px;font-weight:600;font-family:'Segoe UI',sans-serif;">
                                    <svg width="14" height="14" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                    Choose Photo
                                </label>
                                <input type="file" id="profile_photo_input" name="profile_photo" accept="image/*" style="display:none;" onchange="previewPhoto(this)">
                            </div>
                        </div>
                        <p id="photo-filename" style="font-size:12px;color:#717182;margin:0;font-style:italic;">No new file chosen</p>
                    </div>
                </div>

                {{-- Contact Information --}}
                <div class="edit-card">
                    <div class="edit-card-header">
                        <div class="edit-card-icon" style="background:#9b3a54;">
                            <svg width="17" height="17" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </div>
                        <h3 style="font-size:15px;font-weight:700;color:#1a1a1a;margin:0;font-family:'Georgia',serif;">Contact Information</h3>
                    </div>
                    <div class="edit-card-body">
                        <div>
                            <label class="field-label">Contact Email</label>
                            <p class="field-hint">Shown to other alumni — can differ from your login email.</p>
                            <input type="email" name="contact_email" class="field-input"
                                value="{{ old('contact_email', auth()->user()->contact_email ?? auth()->user()->email) }}"
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                        </div>
                        <div>
                            <label class="field-label">Phone Number</label>
                            <input type="text" name="phone" class="field-input"
                                value="{{ old('phone', auth()->user()->phone) }}"
                                placeholder="+63 9XX XXX XXXX"
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">
                        </div>
                        <div>
                            <label class="field-label">Address</label>
                            <textarea name="address" rows="3" class="field-textarea"
                                placeholder="City, Province, Country..."
                                onfocus="this.style.borderColor='#800020';this.style.background='#fff';"
                                onblur="this.style.borderColor='rgba(128,0,32,0.15)';this.style.background='#f8f8f8';">{{ old('address', auth()->user()->address) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Save / Cancel --}}
                <div class="edit-card">
                    <div class="save-card-body">
                        <h3 style="font-size:14px;font-weight:700;color:#1a1a1a;margin:0 0 6px;font-family:'Georgia',serif;">Save Changes</h3>
                        <p style="font-size:13px;color:#717182;margin:0 0 20px;">Your updated profile will be visible to other alumni immediately.</p>
                        <button type="submit" class="btn-save">
                            <svg width="16" height="16" fill="none" stroke="#fff" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Save Profile
                        </button>
                        <a href="{{ route('alumni.profile') }}" class="btn-cancel">Cancel</a>
                    </div>
                </div>

            </div>{{-- end right col --}}

        </div>{{-- end grid --}}
    </form>
</div>

@endsection

@push('scripts')
<script>
function previewPhoto(input) {
    const file = input.files[0];
    if (!file) return;
    document.getElementById('photo-filename').textContent = file.name;
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('photo-preview');
        const initials = document.getElementById('photo-initials');
        preview.src = e.target.result;
        preview.style.display = 'block';
        if (initials) initials.style.display = 'none';
    };
    reader.readAsDataURL(file);
}

const skillsInput = document.querySelector('textarea[name="skills"]');
const preview = document.getElementById('skills-preview');
function renderSkills() {
    const skills = skillsInput.value.split(',').map(s => s.trim()).filter(s => s.length > 0);
    preview.innerHTML = '';
    skills.forEach(skill => {
        const pill = document.createElement('span');
        pill.textContent = skill;
        pill.style.cssText = 'background:rgba(128,0,32,0.07);color:#800020;font-size:12px;font-weight:600;padding:5px 14px;border-radius:50px;border:1px solid rgba(128,0,32,0.12);font-family:Segoe UI,sans-serif;';
        preview.appendChild(pill);
    });
}
skillsInput.addEventListener('input', renderSkills);
renderSkills();
</script>
@endpush