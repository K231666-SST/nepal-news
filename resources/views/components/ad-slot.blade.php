@php
    $ad = \App\Models\Advertisement::getFor($position ?? 'sidebar_top');
    if ($ad) $ad->incrementImpressions();
@endphp

@if($ad)
{{-- Real Advertisement --}}
<div style="margin-bottom:16px;position:relative">
    <div style="font-size:9px;color:#ccc;text-transform:uppercase;letter-spacing:1px;text-align:center;margin-bottom:4px">Advertisement</div>

    @if($ad->type === 'image' && $ad->image_url)
        @if($ad->link_url)
        <a href="{{ $ad->link_url }}" target="_blank" rel="noopener sponsored"
           onclick="fetch('/ads/{{ $ad->id }}/click',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}})"
           style="display:block;border-radius:12px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.1);transition:all .3s"
           onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 24px rgba(0,0,0,0.15)'"
           onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(0,0,0,0.1)'">
            <img src="{{ $ad->image_url }}" alt="{{ $ad->alt_text ?? 'Advertisement' }}"
                 style="width:100%;display:block;border-radius:12px">
        </a>
        @else
        <div style="border-radius:12px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.08)">
            <img src="{{ $ad->image_url }}" alt="{{ $ad->alt_text ?? 'Advertisement' }}"
                 style="width:100%;display:block">
        </div>
        @endif

    @elseif($ad->type === 'code' && $ad->ad_code)
        <div style="border-radius:12px;overflow:hidden;background:white;border:1px solid rgba(0,0,0,0.06);padding:8px">
            {!! $ad->ad_code !!}
        </div>

    @elseif($ad->type === 'text')
        <a href="{{ $ad->link_url ?? '#' }}" target="_blank" rel="noopener sponsored"
           onclick="fetch('/ads/{{ $ad->id }}/click',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Content-Type':'application/json'}})"
           style="display:block;background:linear-gradient(135deg,rgba(192,57,43,0.05),rgba(192,57,43,0.02));border:1.5px solid rgba(192,57,43,0.15);border-radius:12px;padding:16px;text-decoration:none;transition:all .2s"
           onmouseover="this.style.background='rgba(192,57,43,0.08)'" onmouseout="this.style.background='linear-gradient(135deg,rgba(192,57,43,0.05),rgba(192,57,43,0.02))'">
            <div style="font-size:9px;color:#C0392B;font-weight:700;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Sponsored</div>
            <div style="font-size:14px;font-weight:600;color:#1d1d1f;margin-bottom:6px">{{ $ad->title }}</div>
            <div style="font-size:12px;color:#C0392B;font-weight:600">Learn More →</div>
        </a>
    @endif
</div>

@else
{{-- No ad configured - show nothing (clean) --}}
@endif
