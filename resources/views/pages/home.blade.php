@extends('layouts.app')
@section('title','Nepal News Australia — Home')
@section('content')

{{-- BREAKING TICKER --}}
@if(isset($breaking) && $breaking->count())
<div class="breaking-bar">
    <div class="container">
        <div class="breaking-inner">
            <span class="breaking-label">Breaking</span>
            <div class="ticker-wrap">
                <div class="ticker-text">
                    @foreach($breaking as $b)
                    <a href="{{ route('article.show',$b->slug) }}">{{ $b->title }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif


<div class="container main-container">
    <div class="main-layout">
        <main class="main-content">

            {{-- LATEST NEWS --}}
            <section class="news-section">
                <div class="section-header">
                    <h2 class="section-title">Latest News</h2>
                    <span class="section-line"></span>
                    <a href="{{ route('category','all') }}" class="see-all">See All →</a>
                </div>
                <div class="cat-tabs">
                    <button class="cat-tab active" data-cat="all">All</button>
                    @foreach(['nepal','australia','community','business'] as $c)
                    <button class="cat-tab" data-cat="{{ $c }}">{{ ucfirst($c) }}</button>
                    @endforeach
                </div>
                @if(isset($latest) && $latest->count())
                <div class="news-grid" id="latestGrid">
                    @foreach($latest as $article)
                    <div class="news-card" data-cat="{{ $article->category }}">
                        <div class="card-thumb">
                            @if($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                            @else
                                @php $colors=['#8b0000','#1a5276','#1e6b52','#4a235a','#6e4c1e','#1a4f72']; @endphp
                                <div class="card-placeholder" style="background:{{ $colors[$loop->index % 6] }}"></div>
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
                                <span>·</span>
                                <span>{{ number_format($article->views) }} views</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="background:white;border:1px solid #e0dbd5;border-radius:4px;padding:40px;text-align:center;color:#666">
                    <p>No articles yet.</p>
                    @auth<a href="{{ route('articles.create') }}" class="btn-primary" style="margin-top:12px;display:inline-block">+ Write First Article</a>@endauth
                </div>
                @endif
            </section>

            {{-- NEPAL NEWS --}}
            @if(isset($nepalNews) && $nepalNews->count())
            <section class="news-section">
                <div class="section-header">
                    <h2 class="section-title">Nepal News</h2>
                    <span class="section-line"></span>
                    <a href="{{ route('category','nepal') }}" class="see-all">More →</a>
                </div>
                <div class="list-articles">
                    @foreach($nepalNews as $article)
                    <div class="list-card">
                        <div class="list-thumb">
                            @if($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                            @else
                                <div class="list-placeholder" style="background:#003893"></div>
                            @endif
                        </div>
                        <div class="list-body">
                            <span class="list-cat">Nepal</span>
                            <h4><a href="{{ route('article.show',$article->slug) }}">{{ $article->title }}</a></h4>
                            <p>{{ Str::limit($article->summary,100) }}</p>
                            <div class="list-meta">
                                <span>{{ $article->author->name ?? 'Editor' }}</span>
                                <span>·</span>
                                <span>{{ $article->published_at?->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- AUSTRALIA NEWS --}}
            @if(isset($australiaNews) && $australiaNews->count())
            <section class="news-section">
                <div class="section-header">
                    <h2 class="section-title">Australia News</h2>
                    <span class="section-line"></span>
                    <a href="{{ route('category','australia') }}" class="see-all">More →</a>
                </div>
                <div class="news-grid">
                    @foreach($australiaNews as $article)
                    <div class="news-card">
                        <div class="card-thumb">
                            @if($article->featured_image)
                                <img src="{{ $article->featured_image }}" alt="{{ $article->title }}">
                            @else
                                <div class="card-placeholder" style="background:#1a4f72"></div>
                            @endif
                            <span class="card-cat">Australia</span>
                        </div>
                        <div class="card-body">
                            <h3><a href="{{ route('article.show',$article->slug) }}">{{ $article->title }}</a></h3>
                            <p>{{ Str::limit($article->summary,100) }}</p>
                            <div class="card-meta">
                                <span class="card-author">{{ $article->author->name ?? 'Editor' }}</span>
                                <span>·</span>
                                <span>{{ $article->published_at?->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- OPINION --}}
            @if(isset($opinions) && $opinions->count())
            <section class="news-section">
                <div class="section-header">
                    <h2 class="section-title">Opinion &amp; Analysis</h2>
                    <span class="section-line"></span>
                    <a href="{{ route('category','opinion') }}" class="see-all">More →</a>
                </div>
                <div class="opinion-grid">
                    @foreach($opinions as $op)
                    <div class="opinion-card">
                        <div class="op-author">
                            <div class="op-avatar">{{ strtoupper(substr($op->author->name ?? 'E',0,2)) }}</div>
                            <div>
                                <div class="op-name">{{ $op->author->name ?? 'Editor' }}</div>
                                <div class="op-role">{{ ucfirst($op->author->role ?? 'editor') }}</div>
                            </div>
                        </div>
                        <h3><a href="{{ route('article.show',$op->slug) }}">{{ $op->title }}</a></h3>
                        <p>{{ Str::limit($op->summary,120) }}</p>
                        <div class="card-meta" style="margin-top:10px">
                            <span>{{ $op->published_at?->format('d M Y') }}</span>
                            <span>·</span>
                            <span>{{ $op->reading_time ?? 3 }} min read</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- EVENTS --}}
            @if(isset($events) && $events->count())
            <section class="news-section">
                <div class="section-header">
                    <h2 class="section-title">Community Events</h2>
                    <span class="section-line"></span>
                    <a href="{{ route('events.index') }}" class="see-all">Full Calendar →</a>
                </div>
                <div class="events-list">
                    @foreach($events as $event)
                    <div class="event-card">
                        <div class="event-date-box">
                            <div class="ev-month">{{ $event->event_date->format('M') }}</div>
                            <div class="ev-day">{{ $event->event_date->format('d') }}</div>
                        </div>
                        <div class="event-info">
                            <h4>{{ $event->title }}</h4>
                            <p>{{ Str::limit($event->description,100) }}</p>
                            <div class="event-loc">📍 {{ $event->venue }}, {{ $event->city }}</div>
                            <div class="event-meta">
                                <span>👤 {{ $event->organiser }}</span>
                                <span>·</span>
                                <span>{{ $event->is_free ? '🎟 Free' : 'A$'.number_format($event->ticket_price,2) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

        </main>

        <aside class="sidebar">
            @php $trending = \App\Models\Article::published()->orderByDesc('views')->take(5)->get(); @endphp
            @include('components.sidebar')
        </aside>

    </div>
</div>
@endsection
