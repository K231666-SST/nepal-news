@extends('layouts.app')
@section('title', isset($ad) && $ad ? 'Edit Ad' : 'New Advertisement')

@section('content')
<div style="background:#1A252F;color:white;padding:16px 0">
    <div class="container" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap">
        <a href="{{ route('ads.index') }}" style="color:#9ca3af;font-size:13px">← Advertisements</a>
        <h1 style="font-family:Georgia,serif;font-size:20px;font-weight:700">
            {{ isset($ad) && $ad ? 'Edit Advertisement' : 'New Advertisement' }}
        </h1>
    </div>
</div>

<div class="container" style="padding:24px 20px;max-width:800px">
    @if($errors->any())
    <div class="alert alert-error">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
    @endif

    <div style="background:white;border:1px solid rgba(0,0,0,0.08);border-radius:16px;padding:28px;box-shadow:0 4px 16px rgba(0,0,0,0.06)">
        <form method="POST" action="{{ isset($ad) && $ad ? route('ads.update',$ad) : route('ads.store') }}">
            @csrf
            @if(isset($ad) && $ad) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Ad Title * <span style="font-weight:400;color:#aaa;font-size:12px">(internal name only)</span></label>
                <input type="text" name="title" class="form-input" placeholder="e.g. Nepal Airlines Banner — June 2026" value="{{ old('title',$ad?->title??'') }}" required>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Position *</label>
                    <select name="position" class="form-input">
                        @foreach([
                            'sidebar_top'     => '🥇 Sidebar Top (Best)',
                            'sidebar_middle'  => '🥈 Sidebar Middle',
                            'sidebar_bottom'  => '🥉 Sidebar Bottom',
                            'header_banner'   => '📢 Header Banner',
                            'article_inline'  => '📰 Article Inline',
                            'homepage_banner' => '🏠 Homepage Banner',
                        ] as $val => $label)
                        <option value="{{ $val }}" {{ old('position',$ad?->position??'sidebar_top')===$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Ad Type *</label>
                    <select name="type" class="form-input" onchange="toggleAdType(this.value)">
                        <option value="image" {{ old('type',$ad?->type??'image')==='image'?'selected':'' }}>🖼️ Image Ad</option>
                        <option value="code"  {{ old('type',$ad?->type??'image')==='code'?'selected':'' }}>💻 HTML/AdSense Code</option>
                        <option value="text"  {{ old('type',$ad?->type??'image')==='text'?'selected':'' }}>📝 Text Ad</option>
                    </select>
                </div>
            </div>

            {{-- Image ad fields --}}
            <div id="imageFields">
                <div class="form-group">
                    <label class="form-label">Image URL *</label>
                    <input type="url" name="image_url" class="form-input" placeholder="https://example.com/ad-banner.jpg" value="{{ old('image_url',$ad?->image_url??'') }}">
                    <div style="font-size:11px;color:#aaa;margin-top:4px">Recommended sizes: 300×250 (sidebar), 728×90 (banner), 336×280 (article)</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Alt Text</label>
                    <input type="text" name="alt_text" class="form-input" placeholder="Descriptive text for the image" value="{{ old('alt_text',$ad?->alt_text??'') }}">
                </div>
            </div>

            {{-- Code ad fields --}}
            <div id="codeFields" style="display:none">
                <div class="form-group">
                    <label class="form-label">Ad Code * <span style="font-weight:400;color:#aaa;font-size:12px">(Google AdSense, custom HTML)</span></label>
                    <textarea name="ad_code" class="form-input" rows="8" style="font-family:monospace;font-size:12px" placeholder="Paste your Google AdSense code or custom HTML here...">{{ old('ad_code',$ad?->ad_code??'') }}</textarea>
                </div>
            </div>

            {{-- Common fields --}}
            <div class="form-group">
                <label class="form-label">Click URL <span style="font-weight:400;color:#aaa;font-size:12px">(where user goes when they click)</span></label>
                <input type="url" name="link_url" class="form-input" placeholder="https://advertiser-website.com" value="{{ old('link_url',$ad?->link_url??'') }}">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="starts_at" class="form-input" value="{{ old('starts_at',$ad?->starts_at?->format('Y-m-d')??'') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">End Date</label>
                    <input type="date" name="ends_at" class="form-input" value="{{ old('ends_at',$ad?->ends_at?->format('Y-m-d')??'') }}">
                </div>
            </div>

            <label style="display:flex;align-items:center;gap:10px;margin-bottom:20px;cursor:pointer;background:rgba(39,174,96,0.05);border:1px solid rgba(39,174,96,0.15);border-radius:10px;padding:12px 16px">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active',$ad?->is_active??true)?'checked':'' }} style="width:18px;height:18px;accent-color:#27ae60">
                <div>
                    <div style="font-size:14px;font-weight:600;color:#1d1d1f">Active</div>
                    <div style="font-size:12px;color:#aaa">Ad will be displayed on the site when active</div>
                </div>
            </label>

            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <button type="submit" class="btn-primary">{{ isset($ad) && $ad ? '💾 Save Changes' : '📢 Create Advertisement' }}</button>
                <a href="{{ route('ads.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Help box --}}
    <div style="background:rgba(21,67,96,0.05);border:1px solid rgba(21,67,96,0.12);border-radius:12px;padding:20px;margin-top:20px">
        <h4 style="font-size:14px;font-weight:700;color:#154360;margin-bottom:12px">💡 Advertising Guide</h4>
        <div style="font-size:13px;color:#555;line-height:1.7">
            <strong>Image Ads:</strong> Upload your banner image to any hosting service and paste the URL. Best for visual brand campaigns.<br>
            <strong>Google AdSense:</strong> Select "HTML Code" and paste your AdSense ad unit code directly.<br>
            <strong>Text Ads:</strong> Simple text + link format. Good for local business announcements.<br>
            <strong>Tracking:</strong> All ads automatically track impressions and clicks. View stats on the Ads dashboard.
        </div>
    </div>
</div>

@push('scripts')
<script>
function toggleAdType(type) {
    document.getElementById('imageFields').style.display = type === 'image' ? 'block' : 'none';
    document.getElementById('codeFields').style.display  = type === 'code'  ? 'block' : 'none';
}
toggleAdType('{{ old("type", $ad?->type ?? "image") }}');
</script>
@endpush
@endsection
