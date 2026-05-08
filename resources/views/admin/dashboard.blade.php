@extends('layouts.app')
@section('title','Dashboard — Nepal News Australia')

@section('content')
<div style="background:#1A252F;color:white;padding:20px 0">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px">
            <div>
                <h1 style="font-family:Georgia,serif;font-size:24px;font-weight:700">Dashboard</h1>
                <p style="color:#9ca3af;font-size:13px;margin-top:4px">
                    Welcome, <strong style="color:white">{{ auth()->user()->name }}</strong>
                    <span style="background:#C0392B;font-size:10px;padding:2px 8px;border-radius:20px;margin-left:8px;text-transform:capitalize">{{ auth()->user()->role }}</span>
                </p>
            </div>
            <div style="display:flex;gap:10px">
                @if(auth()->user()->isContributor())
                <a href="{{ route('articles.create') }}" class="btn-primary">+ New Article</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf <button type="submit" class="btn-secondary">Sign Out</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container" style="padding:24px 20px">

    {{-- Stats --}}
    <div class="stats-row">
        @foreach([['Total Articles',$stats['total'],'#1a1a2e'],['Published',$stats['published'],'#27ae60'],['Drafts',$stats['drafts'],'#f39c12'],['Total Views',number_format($stats['views']),'#2E86C1']] as [$label,$val,$color])
        <div class="stat-box">
            <div class="stat-lbl">{{ $label }}</div>
            <div class="stat-val" style="color:{{ $color }}">{{ $val }}</div>
        </div>
        @endforeach
    </div>

    {{-- Articles --}}
    <div class="table-card">
        <div class="table-card-head">
            <h3>{{ auth()->user()->isEditor() ? 'All Articles' : 'My Articles' }}</h3>
            @if(auth()->user()->isContributor())
            <a href="{{ route('articles.create') }}" class="btn-primary btn-sm">+ New</a>
            @endif
        </div>
        @if($articles->isEmpty())
        <div style="padding:40px;text-align:center;color:#666">
            No articles yet. <a href="{{ route('articles.create') }}" style="color:#C0392B">Write your first →</a>
        </div>
        @else
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        @if(auth()->user()->isEditor())<th>Author</th>@endif
                        <th>Category</th><th>Status</th><th>Views</th><th>Date</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $article)
                    <tr>
                        <td><a href="{{ route('article.show',$article->slug) }}" class="tbl-title">{{ Str::limit($article->title,55) }}</a></td>
                        @if(auth()->user()->isEditor())<td style="font-size:12px;color:#666">{{ $article->author->name ?? '—' }}</td>@endif
                        <td><span class="cat-chip">{{ $article->category }}</span></td>
                        <td><span class="st-chip status-{{ $article->status }}">{{ $article->status }}</span></td>
                        <td style="font-size:12px;color:#666">{{ number_format($article->views) }}</td>
                        <td style="font-size:12px;color:#999">{{ $article->published_at?->format('d M Y') ?? '—' }}</td>
                        <td>
                            <div style="display:flex;gap:5px;flex-wrap:wrap">
                                <a href="{{ route('articles.edit',$article) }}" class="btn-secondary btn-sm" style="font-size:11px">Edit</a>
                                @if(auth()->user()->isEditor() && $article->status !== 'published')
                                <form method="POST" action="{{ route('articles.publish',$article) }}" style="display:inline">
                                    @csrf <button class="btn-success btn-sm" style="font-size:11px">Publish</button>
                                </form>
                                @endif
                                @if(auth()->user()->isAdmin())
                                <form method="POST" action="{{ route('articles.destroy',$article) }}" style="display:inline" onsubmit="return confirm('Delete?')">
                                    @csrf @method('DELETE') <button class="btn-danger btn-sm" style="font-size:11px">Del</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div style="padding:16px">{{ $articles->links() }}</div>
        @endif
    </div>

    {{-- Pending Events --}}
    @if($pendingEvents->count())
    <div class="table-card" style="margin-top:24px">
        <div class="table-card-head"><h3>Pending Events ({{ $pendingEvents->count() }})</h3></div>
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead><tr><th>Title</th><th>Date</th><th>City</th><th>Organiser</th><th>Action</th></tr></thead>
                <tbody>
                    @foreach($pendingEvents as $event)
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td style="font-size:12px">{{ $event->event_date->format('d M Y') }}</td>
                        <td>{{ $event->city }}</td>
                        <td style="font-size:12px;color:#666">{{ $event->organiser }}</td>
                        <td>
                            <form method="POST" action="{{ route('events.approve',$event) }}" style="display:inline">
                                @csrf <button class="btn-success btn-sm" style="font-size:11px">Approve</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- Users (admin only) --}}
    @if(auth()->user()->isAdmin() && $users->count())
    <div class="table-card" style="margin-top:24px">
        <div class="table-card-head"><h3>User Management</h3></div>
        <div style="overflow-x:auto">
            <table class="data-table">
                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Joined</th></tr></thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td style="font-weight:600">{{ $u->name }}</td>
                        <td style="font-size:12px;color:#666">{{ $u->email }}</td>
                        <td>
                            <form method="POST" action="{{ route('users.role',$u) }}" style="display:inline">
                                @csrf @method('PATCH')
                                <select name="role" onchange="this.form.submit()" style="font-size:12px;border:1px solid #ddd;padding:3px 6px;border-radius:3px;outline:none">
                                    @foreach(['reader','contributor','editor','admin'] as $r)
                                    <option value="{{ $r }}" {{ $u->role===$r?'selected':'' }}>{{ $r }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td><span style="font-size:11px;font-weight:600;color:{{ $u->is_active?'#27ae60':'#e74c3c' }}">{{ $u->is_active?'Active':'Inactive' }}</span></td>
                        <td style="font-size:12px;color:#999">{{ $u->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
