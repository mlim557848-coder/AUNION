@extends('alumni.layout')

@section('title', 'My Donations')

@push('styles')
<style>
.donations-kpi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 36px;
}
.donations-main-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 28px;
    align-items: start;
}
@media (max-width: 768px) {
    .donations-kpi-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }
    .donations-main-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
}
@media (max-width: 480px) {
    .donations-page-wrap {
        padding: 24px 20px 48px !important;
    }
}
</style>
@endpush

@section('content')
<div class="donations-page-wrap" style="padding: 40px 48px 60px; max-width: 1280px; margin: 0 auto; font-family: 'Segoe UI', sans-serif;">

    {{-- Page Header --}}
    <div style="margin-bottom: 32px;">
        <h1 style="font-size: 28px; font-weight: 800; color: #1a1a1a; margin: 0 0 5px; font-family: 'Georgia', serif;">My Donations</h1>
        <p style="font-size: 14px; color: #717182; margin: 0;">Support the alumni community by making a general donation.</p>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span style="font-size: 14px; color: #15803d; font-family: 'Segoe UI', sans-serif;">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px; display: flex; align-items: center; gap: 10px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span style="font-size: 14px; color: #dc2626; font-family: 'Segoe UI', sans-serif;">{{ session('error') }}</span>
        </div>
    @endif

    {{-- KPI Strip --}}
    <div class="donations-kpi-grid">

        <div style="background: #800020; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden; display: flex; flex-direction: column;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Total Approved</p>
            <p style="font-size: 36px; font-weight: 300; line-height: 1; color: #ffffff; margin-top: auto; margin-left: auto; margin-bottom: 0; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($totalDonated, 2) }}</p>
        </div>

        <div style="background: #FDB813; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden; display: flex; flex-direction: column;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.18);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0; color: #5c3700; font-family: 'Segoe UI', sans-serif;">Pending Review</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #5c3700; margin-top: auto; margin-left: auto; margin-bottom: 0; font-family: 'Segoe UI', sans-serif;">{{ $pendingCount }}</p>
        </div>

        <div style="background: #9b3a54; border-radius: 18px; padding: 28px 28px 24px; min-height: 145px; position: relative; overflow: hidden; display: flex; flex-direction: column;">
            <div style="position: absolute; bottom: -28px; right: -28px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.07);"></div>
            <p style="font-size: 14px; font-weight: 400; opacity: 0.82; margin: 0; color: #ffffff; font-family: 'Segoe UI', sans-serif;">Approved Donations</p>
            <p style="font-size: 52px; font-weight: 300; line-height: 1; color: #ffffff; margin-top: auto; margin-left: auto; margin-bottom: 0; font-family: 'Segoe UI', sans-serif;">{{ $approvedCount }}</p>
        </div>

    </div>

    <div class="donations-main-grid">

        {{-- Donate Form --}}
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); padding: 32px;">
            <h2 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin: 0 0 6px; font-family: 'Segoe UI', sans-serif;">Make a Donation</h2>
            <p style="font-size: 13px; color: #717182; margin: 0 0 24px; font-family: 'Segoe UI', sans-serif;">Your donation will be reviewed and approved by the admin before it is recorded.</p>

            <form method="POST" action="{{ route('alumni.donations.store') }}">
                @csrf

                <div style="margin-bottom: 18px;">
                    <label style="font-size: 13px; font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 6px; font-family: 'Segoe UI', sans-serif;">
                        Donation Amount (₱) <span style="color: #800020;">*</span>
                    </label>
                    <input type="number" name="amount" min="1" step="0.01" placeholder="e.g. 500.00"
                        value="{{ old('amount') }}"
                        style="width: 100%; background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; padding: 12px 14px; font-size: 15px; font-weight: 600; color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif; box-sizing: border-box;">
                    @error('amount')
                        <p style="font-size: 12px; color: #dc2626; margin: 4px 0 0; font-family: 'Segoe UI', sans-serif;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quick Amount Buttons --}}
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 18px;">
                    @foreach([100, 250, 500, 1000, 2500] as $preset)
                        <button type="button"
                            onclick="document.querySelector('input[name=amount]').value='{{ $preset }}'"
                            style="background: rgba(128,0,32,0.07); border: 1px solid rgba(128,0,32,0.15); color: #800020; font-size: 12px; font-weight: 600; padding: 6px 14px; border-radius: 20px; cursor: pointer; font-family: 'Segoe UI', sans-serif;">
                            ₱{{ number_format($preset) }}
                        </button>
                    @endforeach
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="font-size: 13px; font-weight: 600; color: #1a1a1a; display: block; margin-bottom: 6px; font-family: 'Segoe UI', sans-serif;">
                        Note <span style="color: #717182; font-weight: 400;">(optional)</span>
                    </label>
                    <textarea name="note" rows="3" placeholder="e.g. For the alumni fund, in memory of..."
                        style="width: 100%; background: #f8f8f8; border: 1px solid rgba(128,0,32,0.15); border-radius: 10px; padding: 12px 14px; font-size: 14px; color: #1a1a1a; outline: none; font-family: 'Segoe UI', sans-serif; resize: vertical; box-sizing: border-box;">{{ old('note') }}</textarea>
                    @error('note')
                        <p style="font-size: 12px; color: #dc2626; margin: 4px 0 0; font-family: 'Segoe UI', sans-serif;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    style="width: 100%; padding: 13px; background: #800020; color: #ffffff; border: none; border-radius: 12px; font-size: 15px; font-weight: 600; cursor: pointer; font-family: 'Segoe UI', sans-serif;"
                    onmouseover="this.style.background='#6b001a'"
                    onmouseout="this.style.background='#800020'">
                    Submit Donation
                </button>
            </form>
        </div>

        {{-- Donation History --}}
        <div style="background: #ffffff; border-radius: 18px; border: 1px solid rgba(128,0,32,0.08); overflow: hidden;">
            <div style="padding: 24px 28px 18px; border-bottom: 1px solid rgba(128,0,32,0.07);">
                <h2 style="font-size: 18px; font-weight: 700; color: #1a1a1a; margin: 0 0 2px; font-family: 'Segoe UI', sans-serif;">Donation History</h2>
                <p style="font-size: 13px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">All your submitted donations</p>
            </div>

            @if($donations->isEmpty())
                <div style="padding: 52px 28px; text-align: center;">
                    <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#800020" stroke-width="1.5" style="opacity: 0.3; display: block; margin: 0 auto 14px;"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    <p style="font-size: 14px; font-weight: 600; color: #1a1a1a; margin: 0 0 4px; font-family: 'Segoe UI', sans-serif;">No donations yet</p>
                    <p style="font-size: 13px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Your donation history will appear here.</p>
                </div>
            @else
                <div style="overflow-y: auto; max-height: 520px;">
                    @foreach($donations as $donation)
                    @php
                        $statusStyle = match($donation->status) {
                            'approved' => ['bg' => '#f0fdf4', 'color' => '#15803d', 'label' => 'Approved'],
                            'rejected' => ['bg' => '#fff1f2', 'color' => '#dc2626', 'label' => 'Rejected'],
                            default    => ['bg' => '#fef9ec', 'color' => '#92400e', 'label' => 'Pending'],
                        };
                    @endphp
                    <div style="padding: 16px 28px; border-bottom: 1px solid rgba(128,0,32,0.06); display: flex; align-items: center; justify-content: space-between; gap: 12px;">
                        <div style="flex: 1; min-width: 0;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 4px;">
                                <span style="font-size: 15px; font-weight: 700; color: #800020; font-family: 'Segoe UI', sans-serif;">₱{{ number_format($donation->amount, 2) }}</span>
                                <span style="font-size: 11px; font-weight: 600; padding: 3px 10px; border-radius: 20px; background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['color'] }};">{{ $statusStyle['label'] }}</span>
                            </div>
                            @if($donation->note)
                                <p style="font-size: 12px; color: #717182; margin: 0 0 3px; font-family: 'Segoe UI', sans-serif; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $donation->note }}</p>
                            @endif
                            <p style="font-size: 11px; color: #9ca3af; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $donation->created_at->format('M d, Y · g:i A') }}</p>
                        </div>
                        @if($donation->status === 'approved' && $donation->approvedBy)
                            <div style="text-align: right; flex-shrink: 0;">
                                <p style="font-size: 11px; color: #717182; margin: 0; font-family: 'Segoe UI', sans-serif;">Approved by</p>
                                <p style="font-size: 12px; font-weight: 600; color: #1a1a1a; margin: 0; font-family: 'Segoe UI', sans-serif;">{{ $donation->approvedBy->name }}</p>
                            </div>
                        @endif
                    </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if($donations->hasPages())
                    <div style="padding: 16px 28px; border-top: 1px solid rgba(128,0,32,0.07); display: flex; justify-content: center; gap: 8px; flex-wrap: wrap;">
                        @if($donations->onFirstPage())
                            <span style="padding: 6px 14px; border-radius: 8px; background: #f3f4f6; color: #9ca3af; font-size: 13px; font-family: 'Segoe UI', sans-serif;">← Prev</span>
                        @else
                            <a href="{{ $donations->previousPageUrl() }}" style="padding: 6px 14px; border-radius: 8px; background: #fff; border: 1px solid rgba(128,0,32,0.15); color: #800020; font-size: 13px; font-family: 'Segoe UI', sans-serif; text-decoration: none;">← Prev</a>
                        @endif
                        @if($donations->hasMorePages())
                            <a href="{{ $donations->nextPageUrl() }}" style="padding: 6px 14px; border-radius: 8px; background: #fff; border: 1px solid rgba(128,0,32,0.15); color: #800020; font-size: 13px; font-family: 'Segoe UI', sans-serif; text-decoration: none;">Next →</a>
                        @else
                            <span style="padding: 6px 14px; border-radius: 8px; background: #f3f4f6; color: #9ca3af; font-size: 13px; font-family: 'Segoe UI', sans-serif;">Next →</span>
                        @endif
                    </div>
                @endif
            @endif
        </div>

    </div>
</div>
@endsection