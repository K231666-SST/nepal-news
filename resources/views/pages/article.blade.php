@extends('layouts.app')
@section('title',$article->title)
@section('description',$article->summary)

@section('content')
<div class="container main-container">
    <div class="main-layout">
        <article class="main-content">

            <nav class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> /
                <a href="{{ route('category',$article->category) }}">{{ ucfirst($article->category) }}</a>
            </nav>

            @auth
            @if(auth()->user()->isEditor() || $article->author_id === auth()->id())
            <div class="editor-bar">
                <span class="status-badge status-{{ $article->status }}">{{ strtoupper($article->status) }}</span>
                @if(auth()->user()->isEditor() && $article->status !== 'published')
                <form method="POST" action="{{ route('articles.publish',$article) }}" style="display:inline">
                    @csrf <button class="btn-success btn-sm">✅ Publish</button>
                </form>
                @endif
                <a href="{{ route('articles.edit',$article) }}" class="btn-secondary btn-sm">✏️ Edit</a>
                @if(auth()->user()->isAdmin())
                <form method="POST" action="{{ route('articles.destroy',$article) }}" style="display:inline" onsubmit="return confirm('Delete?')">
                    @csrf @method('DELETE') <button class="btn-danger btn-sm">🗑️ Delete</button>
                </form>
                @endif
            </div>
            @endif
            @endauth

            <div class="article-wrap">
                <div class="article-badges">
                    <span class="badge badge-cat">{{ ucfirst($article->category) }}</span>
                    @if($article->is_breaking)<span class="badge badge-breaking">Breaking</span>@endif
                    @if($article->is_featured)<span class="badge badge-featured">Featured</span>@endif
                </div>

                <h1 class="article-title">{{ $article->title }}</h1>
                <p class="article-summary">{{ $article->summary }}</p>

                <div class="article-meta-bar">
                    <div class="article-author">
                        <div class="art-avatar">{{ strtoupper(substr($article->author->name ?? 'E',0,1)) }}</div>
                        <div>
                            <div class="art-name">{{ $article->author->name ?? 'Editor' }}</div>
                            <div class="art-role">{{ ucfirst($article->author->role ?? 'editor') }}</div>
                        </div>
                    </div>
                    <div class="art-info">
                        <span>📅 {{ $article->published_at?->format('d F Y') }}</span>
                        <span>👁 {{ number_format($article->views) }} views</span>
                        <span>⏱ {{ $article->reading_time ?? 3 }} min read</span>
                    </div>
                </div>

                @if($article->featured_image)
                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="article-img">
                @endif

                <div class="article-content">{!! $article->content !!}</div>

                @if($article->tags->count())
                <div class="article-tags">
                    <strong>Tags: </strong>
                    @foreach($article->tags as $tag)
                    <a href="{{ route('category',$article->category) }}?tag={{ $tag->slug }}" class="tag-chip">#{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif

                <div class="share-bar">
                    <span>Share: </span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="share-btn share-fb">Facebook</a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" target="_blank" class="share-btn share-tw">Twitter</a>
                    <button onclick="navigator.clipboard.writeText(window.location.href);alert('Link copied!')" class="share-btn share-copy">Copy Link</button>
                </div>
            </div>

        </article>

        <aside class="sidebar">
            @if(isset($related) && $related->count())
            <div class="widget">
                <div class="widget-head">Related Articles</div>
                <div class="widget-body no-pad">
                    @foreach($related as $rel)
                    <div class="related-item">
                        <a href="{{ route('article.show',$rel->slug) }}">{{ $rel->title }}</a>
                        <div class="trend-meta">{{ $rel->published_at?->format('d M Y') }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            @php $trending = \App\Models\Article::published()->orderByDesc('views')->take(5)->get(); @endphp
            @include('components.sidebar')
        </aside>
    </div>
</div>
@endsection
