{{-- resources/views/components/ad-slot.blade.php --}}
{{-- Usage: @include('components.ad-slot', ['position' => 'sidebar_top']) --}}

@php
    $ad = \App\Models\Advertisement::getFor($position ?? 'sidebar_top');
    if ($ad) $ad->incrementImpressions();
@endphp

@if($ad)
<div class="ad-slot" data-ad-id="{{ $ad->id }}" style="margin-bottom:16px">

    @if($ad->type === 'code' && $ad->ad_code)
        {{-- Google AdSense or custom HTML ad --}}
        <div class="ad-code-wrap" style="border-radius:12px;overflow:hidden;background:white;border:1px solid rgba(0,0,0,0.06)">
            {!! $ad->ad_code !!}
        </div>

    @elseif($ad->type === 'image' && $ad->image_url)
        {{-- Image ad --}}
        @if($ad->link_url)
        <a href="{{ $ad->link_url }}" target="_blank" rel="noopener sponsored"
           onclick="trackAdClick({{ $ad->id }})"
           style="display:block;border-radius:12px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.08);transition:all .2s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.08)'">
            <img src="{{ $ad->image_url }}" alt="{{ $ad->alt_text ?? 'Advertisement' }}"
                 style="width:100%;display:block;border-radius:12px">
        </a>
        @else
        <div style="border-radius:12px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.08)">
            <img src="{{ $ad->image_url }}" alt="{{ $ad->alt_text ?? 'Advertisement' }}"
                 style="width:100%;display:block">
        </div>
        @endif

    @elseif($ad->type === 'text')
        {{-- Text/sponsored content ad --}}
        <div style="background:linear-gradient(135deg,rgba(192,57,43,0.04),rgba(192,57,43,0.02));border:1.5px solid rgba(192,57,43,0.12);border-radius:12px;padding:16px">
            <div style="font-size:9px;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Sponsored</div>
            <p style="font-size:14px;font-weight:600;color:#1d1d1f;margin-bottom:8px">{{ $ad->title }}</p>
            @if($ad->link_url)
            <a href="{{ $ad->link_url }}" target="_blank" rel="noopener sponsored"
               onclick="trackAdClick({{ $ad->id }})"
               style="font-size:12px;color:#C0392B;font-weight:600">Learn More →</a>
            @endif
        </div>
    @endif

    <div style="text-align:right;margin-top:3px">
        <span style="font-size:9px;color:#ccc;text-transform:uppercase;letter-spacing:.5px">Advertisement</span>
    </div>
</div>
@else
{{-- Fallback placeholder if no ad configured --}}
<div style="border:2px dashed #e0e0e0;background:rgba(0,0,0,0.01);border-radius:12px;padding:28px 20px;text-align:center;color:#ccc;font-size:11px;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px">
    <div style="font-size:20px;margin-bottom:6px">📢</div>
    Advertisement<br>
    <span style="font-size:9px">Contact us to advertise here</span>
</div>
@endif

<script>
function trackAdClick(adId) {
    fetch('/ads/' + adId + '/click', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Content-Type': 'application/json'}
    }).catch(() => {});
}
</script>
