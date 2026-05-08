@extends('layouts.app')
@section('title','Advertisements — Dashboard')

@section('content')
<div style="background:#1A252F;color:white;padding:20px 0">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
            <div>
                <a href="{{ route('dashboard') }}" style="color:#9ca3af;font-size:13px">← Dashboard</a>
                <h1 style="font-family:Georgia,serif;font-size:24px;font-weight:700;margin-top:4px">Advertisement Manager</h1>
                <p style="color:#9ca3af;font-size:13px">Manage all ad placements across the website</p>
            </div>
            <a href="{{ route('ads.create') }}" class="btn-primary">+ New Advertisement</a>
        </div>
    </div>
</div>

<div class="container" style="padding:24px 20px">

    {{-- Stats --}}
    <div class="stats-row" style="grid-template-columns:repeat(4,1fr);margin-bottom:24px">
        <div class="stat-box">
            <div class="stat-lbl">Total Ads</div>
            <div class="stat-val" style="color:#1a1a2e">{{ $ads->total() }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-lbl">Active</div>
            <div class="stat-val" style="color:#27ae60">{{ $ads->where('is_active',true)->count() }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-lbl">Total Impressions</div>
            <div class="stat-val" style="color:#2E86C1">{{ number_format($ads->sum('impressions')) }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-lbl">Total Clicks</div>
            <div class="stat-val" style="color:#C0392B">{{ number_format($ads->sum('clicks')) }}</div>
        </div>
    </div>

    {{-- Ad positions guide --}}
    <div style="background:white;border:1px solid rgba(0,0,0,0.08);border-radius:16px;padding:20px;margin-bottom:24px;box-shadow:0 2px 8px rgba(0,0,0,0.06)">
        <h3 style="font-family:Georgia,serif;font-size:16px;margin-bottom:14px;color:#1d1d1f">📍 Available Ad Positions</h3>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px">
            @foreach([
                ['sidebar_top','Sidebar Top','Appears at top of sidebar on all pages. Best visibility.','🥇'],
                ['sidebar_middle','Sidebar Middle','Between widgets in sidebar. Good for square ads.','🥈'],
                ['sidebar_bottom','Sidebar Bottom','Bottom of sidebar. Good for newsletter-style ads.','🥉'],
                ['header_banner','Header Banner','Full-width banner below the navigation bar.','📢'],
                ['article_inline','Article Inline','Appears within article content. High engagement.','📰'],
                ['homepage_banner','Homepage Banner','Prominent placement on homepage only.','🏠'],
            ] as [$key,$label,$desc,$icon])
            <div style="background:rgba(0,0,0,0.02);border:1px solid rgba(0,0,0,0.06);border-radius:10px;padding:12px">
                <div style="font-size:18px;margin-bottom:6px">{{ $icon }}</div>
                <div style="font-size:13px;font-weight:700;color:#1d1d1f;margin-bottom:3px">{{ $label }}</div>
                <div style="font-size:11px;color:#6e6e73">{{ $desc }}</div>
                <div style="margin-top:6px"><code style="font-size:10px;background:#f0f0f0;padding:2px 6px;border-radius:4px;color:#666">{{ $key }}</code></div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Ads table --}}
    <div class="table-card">
        <div class="table-card-head">
            <h3>All Advertisements</h3>
            <a href="{{ route('ads.create') }}" class="btn-primary btn-sm">+ New Ad</a>
        </div>
        @if($ads->isEmpty())
        <div style="padding:60px;text-align:center;color:#666">
            <div style="font-size:40px;margin-bottom:12px">📢</div>
            <p style="font-size:16px;margin-bottom:8px">No advertisements yet</p>
            <a href="{{ route('ads.create') }}" class="btn-primary">Create First Ad</a>
        </div>
        @else
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Impressions</th>
                        <th>Clicks</th>
                        <th>CTR</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ads as $ad)
                    <tr>
                        <td>
                            <div style="font-weight:600;font-size:13px;color:#1d1d1f">{{ $ad->title }}</div>
                            @if($ad->link_url)
                            <div style="font-size:11px;color:#aaa">{{ Str::limit($ad->link_url,40) }}</div>
                            @endif
                        </td>
                        <td>
                            <span style="background:rgba(21,67,96,0.1);color:#154360;font-size:10px;padding:3px 8px;border-radius:20px;font-weight:600;border:1px solid rgba(21,67,96,0.15)">
                                {{ str_replace('_',' ',ucfirst($ad->position)) }}
                            </span>
                        </td>
                        <td><span style="font-size:12px;color:#666;text-transform:capitalize">{{ $ad->type }}</span></td>
                        <td>
                            <form method="POST" action="{{ route('ads.toggle',$ad) }}" style="display:inline">
                                @csrf
                                <button style="background:{{ $ad->is_active ? 'rgba(39,174,96,0.1)' : 'rgba(0,0,0,0.05)' }};color:{{ $ad->is_active ? '#1e8449' : '#aaa' }};border:1px solid {{ $ad->is_active ? 'rgba(39,174,96,0.2)' : 'rgba(0,0,0,0.1)' }};font-size:11px;padding:4px 12px;border-radius:20px;cursor:pointer;font-weight:600">
                                    {{ $ad->is_active ? '✅ Active' : '⏸ Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td style="font-size:13px;color:#666">{{ number_format($ad->impressions) }}</td>
                        <td style="font-size:13px;color:#666">{{ number_format($ad->clicks) }}</td>
                        <td style="font-size:13px;font-weight:600;color:{{ $ad->ctr > 2 ? '#27ae60' : '#666' }}">{{ $ad->ctr }}</td>
                        <td style="font-size:12px;color:#999">{{ $ad->ends_at ? $ad->ends_at->format('d M Y') : '—' }}</td>
                        <td>
                            <div style="display:flex;gap:5px">
                                <a href="{{ route('ads.edit',$ad) }}" class="btn-secondary btn-sm">Edit</a>
                                <form method="POST" action="{{ route('ads.destroy',$ad) }}" onsubmit="return confirm('Delete this ad?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-danger btn-sm">Del</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px">{{ $ads->links() }}</div>
        @endif
    </div>
</div>
@endsection
