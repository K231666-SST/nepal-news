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
        <form method="POST"
              action="{{ isset($ad) && $ad ? route('ads.update',$ad) : route('ads.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if(isset($ad) && $ad) @method('PUT') @endif

            <div class="form-group">
                <label class="form-label">Ad Title * <span style="font-weight:400;color:#aaa;font-size:12px">(internal name only)</span></label>
                <input type="text" name="title" class="form-input"
                       placeholder="e.g. Nepal Airlines Banner — June 2026"
                       value="{{ old('title',$ad?->title??'') }}" required>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Position *</label>
                    <select name="position" class="form-input">
                        @foreach([
                            'sidebar_top'     => '🥇 Sidebar Top (Best visibility)',
                            'sidebar_middle'  => '🥈 Sidebar Middle',
                            'sidebar_bottom'  => '🥉 Sidebar Bottom',
                            'header_banner'   => '📢 Header Banner (Full width)',
                            'article_inline'  => '📰 Article Inline (High engagement)',
                            'homepage_banner' => '🏠 Homepage Banner',
                        ] as $val => $label)
                        <option value="{{ $val }}" {{ old('position',$ad?->position??'sidebar_top')===$val?'selected':'' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Ad Type *</label>
                    <select name="type" class="form-input" id="adTypeSelect" onchange="toggleAdType(this.value)">
                        <option value="image" {{ old('type',$ad?->type??'image')==='image'?'selected':'' }}>🖼️ Image Ad</option>
                        <option value="code"  {{ old('type',$ad?->type??'image')==='code'?'selected':'' }}>💻 HTML/AdSense Code</option>
                        <option value="text"  {{ old('type',$ad?->type??'image')==='text'?'selected':'' }}>📝 Text Ad</option>
                    </select>
                </div>
            </div>

            {{-- IMAGE AD --}}
            <div id="imageFields">
                <div class="form-group">
                    <label class="form-label">Upload Image</label>
                    {{-- Upload option --}}
                    <div style="border:2px dashed rgba(192,57,43,0.3);border-radius:12px;padding:20px;text-align:center;background:rgba(192,57,43,0.02);margin-bottom:10px;cursor:pointer" onclick="document.getElementById('imageUpload').click()" id="uploadZone">
                        <input type="file" id="imageUpload" name="image_file" accept="image/*" style="display:none" onchange="previewImage(this)">
                        <div id="uploadPlaceholder">
                            <div style="font-size:32px;margin-bottom:8px">🖼️</div>
                            <div style="font-size:14px;font-weight:600;color:#C0392B">Click to upload image</div>
                            <div style="font-size:12px;color:#aaa;margin-top:4px">PNG, JPG, GIF up to 5MB</div>
                            <div style="font-size:11px;color:#bbb;margin-top:4px">Recommended: 300×250 (sidebar) · 728×90 (banner) · 336×280 (article)</div>
                        </div>
                        <img id="imagePreview" style="display:none;max-height:150px;border-radius:8px;margin:0 auto">
                    </div>

                    {{-- OR URL option --}}
                    <div style="display:flex;align-items:center;gap:10px;margin:10px 0">
                        <div style="flex:1;height:1px;background:rgba(0,0,0,0.08)"></div>
                        <span style="font-size:12px;color:#aaa;font-weight:500">OR paste image URL</span>
                        <div style="flex:1;height:1px;background:rgba(0,0,0,0.08)"></div>
                    </div>
                    <input type="url" name="image_url" class="form-input"
                           placeholder="https://example.com/ad-banner.jpg"
                           value="{{ old('image_url',$ad?->image_url??'') }}"
                           onchange="document.getElementById('urlPreview').src=this.value;document.getElementById('urlPreview').style.display=this.value?'block':'none'">
                    <img id="urlPreview" src="{{ $ad?->image_url??'' }}" style="max-height:100px;margin-top:8px;border-radius:8px;{{ $ad?->image_url ? '' : 'display:none' }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Alt Text <span style="font-weight:400;color:#aaa;font-size:12px">(for accessibility)</span></label>
                    <input type="text" name="alt_text" class="form-input"
                           placeholder="e.g. Nepal Airlines — Book your flight today"
                           value="{{ old('alt_text',$ad?->alt_text??'') }}">
                </div>
            </div>

            {{-- CODE AD --}}
            <div id="codeFields" style="display:none">
                <div class="form-group">
                    <label class="form-label">Ad Code * <span style="font-weight:400;color:#aaa;font-size:12px">(Google AdSense or custom HTML)</span></label>
                    <textarea name="ad_code" class="form-input" rows="8"
                              style="font-family:monospace;font-size:12px"
                              placeholder="<!-- Paste your Google AdSense code here -->&#10;<ins class='adsbygoogle'...>">{{ old('ad_code',$ad?->ad_code??'') }}</textarea>
                    <div style="margin-top:8px;padding:10px;background:rgba(21,67,96,0.05);border-radius:8px;border:1px solid rgba(21,67,96,0.1)">
                        <div style="font-size:12px;font-weight:600;color:#154360;margin-bottom:4px">💡 Google AdSense</div>
                        <div style="font-size:12px;color:#555">Go to <strong>adsense.google.com</strong> → Ads → By ad unit → Create new ad → Copy code → Paste above</div>
                    </div>
                </div>
            </div>

            {{-- Click URL --}}
            <div class="form-group">
                <label class="form-label">Click URL <span style="font-weight:400;color:#aaa;font-size:12px">(where user goes when they click)</span></label>
                <input type="url" name="link_url" class="form-input"
                       placeholder="https://advertiser-website.com"
                       value="{{ old('link_url',$ad?->link_url??'') }}">
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
                <div class="form-group">
                    <label class="form-label">Start Date <span style="font-weight:400;color:#aaa;font-size:12px">(optional)</span></label>
                    <input type="date" name="starts_at" class="form-input"
                           value="{{ old('starts_at',$ad?->starts_at?->format('Y-m-d')??'') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">End Date <span style="font-weight:400;color:#aaa;font-size:12px">(optional)</span></label>
                    <input type="date" name="ends_at" class="form-input"
                           value="{{ old('ends_at',$ad?->ends_at?->format('Y-m-d')??'') }}">
                </div>
            </div>

            <label style="display:flex;align-items:center;gap:10px;margin-bottom:20px;cursor:pointer;background:rgba(39,174,96,0.05);border:1px solid rgba(39,174,96,0.15);border-radius:10px;padding:12px 16px">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active',$ad?->is_active??true)?'checked':'' }}
                       style="width:18px;height:18px;accent-color:#27ae60">
                <div>
                    <div style="font-size:14px;font-weight:600;color:#1d1d1f">Active</div>
                    <div style="font-size:12px;color:#aaa">Ad will be displayed on the site immediately</div>
                </div>
            </label>

            <div style="display:flex;gap:10px;flex-wrap:wrap">
                <button type="submit" class="btn-primary">
                    {{ isset($ad) && $ad ? '💾 Save Changes' : '📢 Create Advertisement' }}
                </button>
                <a href="{{ route('ads.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    {{-- Ad positions visual guide --}}
    <div style="background:white;border:1px solid rgba(0,0,0,0.08);border-radius:16px;padding:24px;margin-top:20px">
        <h4 style="font-size:15px;font-weight:700;color:#1d1d1f;margin-bottom:16px">📍 Ad Position Guide</h4>
        <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:12px">
            @foreach([
                ['sidebar_top','🥇 Sidebar Top','Best visibility — appears first in sidebar on every page','High'],
                ['sidebar_middle','🥈 Sidebar Middle','Between widgets — good for square format ads','Medium'],
                ['sidebar_bottom','🥉 Sidebar Bottom','Bottom of sidebar — good for newsletter-style ads','Low'],
                ['header_banner','📢 Header Banner','Full-width below navigation — maximum exposure','Very High'],
                ['article_inline','📰 Article Inline','Inside article content — highest engagement rate','Very High'],
                ['homepage_banner','🏠 Homepage Banner','Homepage only — great for brand awareness','High'],
            ] as [$key,$label,$desc,$level])
            <div style="background:rgba(0,0,0,0.02);border:1px solid rgba(0,0,0,0.06);border-radius:10px;padding:12px">
                <div style="font-size:13px;font-weight:700;color:#1d1d1f;margin-bottom:3px">{{ $label }}</div>
                <div style="font-size:11px;color:#6e6e73;margin-bottom:6px">{{ $desc }}</div>
                <span style="font-size:10px;font-weight:600;padding:2px 8px;border-radius:20px;background:{{ $level==='Very High'?'rgba(39,174,96,0.1)':($level==='High'?'rgba(52,152,219,0.1)':($level==='Medium'?'rgba(243,156,18,0.1)':'rgba(0,0,0,0.05)')) }};color:{{ $level==='Very High'?'#1e8449':($level==='High'?'#1a5276':($level==='Medium'?'#d68910':'#666')) }}">
                    {{ $level }} Visibility
                </span>
            </div>
            @endforeach
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

function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
            document.getElementById('uploadPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Drag and drop
const zone = document.getElementById('uploadZone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.style.borderColor = '#C0392B'; zone.style.background = 'rgba(192,57,43,0.05)'; });
zone.addEventListener('dragleave', () => { zone.style.borderColor = 'rgba(192,57,43,0.3)'; zone.style.background = 'rgba(192,57,43,0.02)'; });
zone.addEventListener('drop', e => {
    e.preventDefault();
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
        document.getElementById('imageUpload').files = e.dataTransfer.files;
        previewImage(document.getElementById('imageUpload'));
    }
    zone.style.borderColor = 'rgba(192,57,43,0.3)';
});
</script>
@endpush
@endsection
