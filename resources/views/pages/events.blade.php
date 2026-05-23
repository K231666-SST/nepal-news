@extends('layouts.app')
@section('title','Community Events — Nepal News Australia')

@section('content')
<div class="container" style="padding:24px 20px">
    <div class="page-header" style="display:flex;justify-content:space-between;align-items:flex-end;flex-wrap:wrap;gap:12px">
        <div>
            <h1 style="font-family:Georgia,serif;font-size:26px;font-weight:700;color:#1A252F">Community Events</h1>
            <p style="color:#666;font-size:14px;margin-top:4px">Upcoming events for the Nepali-Australian community</p>
        </div>
        @auth
        <button onclick="document.getElementById('evForm').style.display=document.getElementById('evForm').style.display==='none'?'block':'none'" class="btn-primary">+ Submit Event</button>
        @endauth
    </div>

    <div class="cat-nav" style="margin:16px 0">
        <a href="{{ route('events.index') }}" class="cat-pill {{ !request('city')?'active':'' }}">All Cities</a>
        @foreach(['Sydney','Melbourne','Brisbane','Perth','Adelaide','Canberra'] as $city)
        <a href="{{ route('events.index',['city'=>$city]) }}" class="cat-pill {{ request('city')===$city?'active':'' }}">{{ $city }}</a>
        @endforeach
    </div>

    @auth
    <div id="evForm" style="display:none;background:white;border:1px solid #e0dbd5;border-radius:4px;padding:22px;margin-bottom:22px;box-shadow:0 2px 8px rgba(0,0,0,.07)">
        <h3 style="font-family:Georgia,serif;font-size:18px;margin-bottom:16px">Submit a Community Event</h3>
        <form method="POST" action="{{ route('events.store') }}">
            @csrf
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px">
                <div class="form-group"><label class="form-label">Event Title *</label><input type="text" name="title" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Date &amp; Time *</label><input type="datetime-local" name="event_date" class="form-input" required></div>
                <div class="form-group"><label class="form-label">Venue *</label><input type="text" name="venue" class="form-input" required></div>
                <div class="form-group">
                    <label class="form-label">City *</label>
                    <select name="city" class="form-input">
                        @foreach(['Sydney','Melbourne','Brisbane','Perth','Adelaide','Canberra','Other'] as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group"><label class="form-label">Organiser *</label><input type="text" name="organiser" class="form-input" required></div>
            <div class="form-group"><label class="form-label">Description *</label><textarea name="description" rows="3" class="form-input" required></textarea></div>
            <div style="display:flex;gap:10px;margin-top:8px">
                <button type="submit" class="btn-primary">Submit Event</button>
                <button type="button" onclick="document.getElementById('evForm').style.display='none'" class="btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
    @endauth

    @if($events->isEmpty())
    <div style="background:white;border:1px solid #e0dbd5;border-radius:4px;padding:60px;text-align:center;color:#666">
        <p style="font-size:16px">No upcoming events found.</p>
    </div>
    @else
    <div class="events-page-grid">
        @foreach($events as $event)
        <div class="ev-full-card">
            <div class="ev-date-big">
                <div class="m">{{ $event->event_date->format('M') }}</div>
                <div class="d">{{ $event->event_date->format('d') }}</div>
                <div class="y">{{ $event->event_date->format('Y') }}</div>
            </div>
            <div class="ev-card-body">
                <span class="city-chip">{{ $event->city }}</span>
                <h3>{{ $event->title }}</h3>
                <p>{{ Str::limit($event->description,120) }}</p>
                <div class="ev-details">
                    <span><i class="fa-solid fa-location-dot"></i> {{ $event->venue }}</span>
                    <span><i class="fa-regular fa-user"></i> {{ $event->organiser }}</span>
                    <span>{{ $event->is_free ? 'Free' : 'A$'.number_format($event->ticket_price,2) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="pagination-wrap">{{ $events->links() }}</div>
    @endif
</div>
@endsection
