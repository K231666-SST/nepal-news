@extends('layouts.app')
@section('title',($categories[$cat??'all']??'News').' — Nepal News Australia')

@section('content')
<div class="container main-container">
    <div class="main-layout">
        <main class="main-content">

            <div class="page-header">
                <h1>{{ $categories[$cat??'all'] ?? 'All News' }}</h1>
                <p>{{ $articles->total() }} articles{{ request('search') ? ' matching "'.request('search').'"' : '' }}</p>
            </div>

            <div class="cat-nav">
                @foreach($categories as $key => $label)
                <a href="{{ route('category',$key) }}" class="cat-pill {{ ($cat??'all')===$key?'active':'' }}">{{ $label }}</a>
                @endforeach
            </div>

            <form method="GET" class="search-bar" style="display:flex;gap:8px;margin-bottom:18px">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." class="form-input" style="flex:1">
                <button type="submit" class="btn-primary">Search</button>
                @if(request('search'))
                <a href="{{ route('category',$cat??'all') }}" class="btn-secondary">✕ Clear</a>
                @endif
            </form>

            @if($articles->isEmpty())
            <div style="background:white;border:1px solid #e0dbd5;border-radius:4px;padding:60px;text-align:center;color:#666">
                <p style="font-size:16px;margin-bottom:12px">No articles found.</p>
                <a href="{{ route('home') }}" class="btn-primary">← Back to Home</a>
            </div>
            @else
            <div class="news-grid">
                @foreach($articles as $article)
                <div class="news-card">
                    <div class="card-thumb">
                        @if($article->featured_image)
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                        @else
                            @php $colors=['#8b0000','#1a5276','#1e6b52','#4a235a','#6e4c1e','#1a4f72']; @endphp
                            <div class="card-placeholder" style="background:{{ $colors[$loop->index%6] }}"></div>
                        @endif
                        <span class="card-cat">{{ ucfirst($article->category) }}</span>
                    </div>
                    <div class="card-body">
                        <h3><a href="{{ route('article.show',$article->slug) }}">{{ $article->title }}</a></h3>
                        <p>{{ Str::limit($article->summary,100) }}</p>
                        <div class="card-meta">
                            <span class="card-author">{{ $article->author->name ?? 'Editor' }}</span>
                            <span>·</span>
                            <span>{{ $article->published_at?->format('d M Y') }}</span>
                        </div>
                        @if($article->tags->count())
                        <div style="display:flex;gap:4px;flex-wrap:wrap;margin-top:8px">
                            @foreach($article->tags->take(3) as $tag)
                            <a href="{{ route('category',$article->category) }}?tag={{ $tag->slug }}" style="font-size:11px;background:#f3f4f6;color:#666;padding:2px 8px;border-radius:20px;border:1px solid #e0dbd5">#{{ $tag->name }}</a>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            <div class="pagination-wrap">{{ $articles->links() }}</div>
            @endif

        </main>

        <aside class="sidebar">
            @include('components.sidebar')
        </aside>
    </div>
</div>
@endsection
