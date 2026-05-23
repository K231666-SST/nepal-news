@extends('layouts.app')
@section('title', isset($article) && $article ? 'Edit Article' : 'Write Article')

@section('content')
<div style="background:#1A252F;color:white;padding:16px 0;position:sticky;top:0;z-index:100">
    <div class="container" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px">
        <div style="display:flex;align-items:center;gap:16px">
            <a href="{{ route('dashboard') }}" style="color:#9ca3af;font-size:13px">← Dashboard</a>
            <h1 style="font-family:Georgia,serif;font-size:20px;font-weight:700">
                {{ isset($article) && $article ? 'Edit Article' : 'Write New Article' }}
            </h1>
        </div>
        <div id="wordCount" style="font-size:12px;color:#9ca3af">0 words</div>
    </div>
</div>

<div class="container" style="padding:24px 20px">
    @if($errors->any())
    <div class="alert alert-error">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
    </div>
    @endif

    <div style="display:grid;grid-template-columns:1fr 280px;gap:20px;align-items:start">

        <form method="POST"
              action="{{ isset($article) && $article ? route('articles.update',$article) : route('articles.store') }}"
              id="articleForm">
            @csrf
            @if(isset($article) && $article) @method('PUT') @endif
            <input type="hidden" name="status" id="statusInput" value="draft">

            <div style="background:white;border:1px solid #e0dbd5;border-radius:4px;padding:20px;box-shadow:0 2px 8px rgba(0,0,0,.07)">
                <div class="form-group">
                    <label class="form-label">Headline / Title *</label>
                    <input type="text" name="title" class="form-input"
                           style="font-family:Georgia,serif;font-size:18px;font-weight:700"
                           placeholder="Write a compelling headline..."
                           value="{{ old('title', $article?->title ?? '') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Summary * <span style="font-weight:400;color:#999;font-size:12px">(max 500 chars)</span></label>
                    <textarea name="summary" class="form-input" rows="3" maxlength="500" placeholder="Brief summary..." required>{{ old('summary', $article?->summary ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Content * <span style="font-weight:400;color:#999;font-size:12px">(HTML supported)</span></label>
                    <textarea name="content" id="contentArea" class="form-input" rows="20" style="font-family:monospace;font-size:13px" placeholder="<p>Write your article here...</p>" required>{{ old('content', $article?->content ?? '') }}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Featured Image URL <span style="font-weight:400;color:#999;font-size:12px">(optional)</span></label>
                    <input type="url" name="featured_image" class="form-input" placeholder="https://example.com/image.jpg"
                           value="{{ old('featured_image', $article?->featured_image ?? '') }}">
                </div>
            </div>

            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:16px">
                <button type="button" onclick="setStatus('draft')" class="btn-secondary"><i class="fa-regular fa-floppy-disk"></i> Save Draft</button>
                <button type="button" onclick="setStatus('pending')" class="btn-primary"><i class="fa-solid fa-paper-plane"></i> Submit for Review</button>
                @if(auth()->user()->isEditor())
                <button type="button" onclick="setStatus('published')" class="btn-success"><i class="fa-solid fa-circle-check"></i> Publish Now</button>
                @endif
                <a href="{{ route('dashboard') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>

        {{-- Settings Panel --}}
        <div style="background:white;border:1px solid #e0dbd5;border-radius:4px;padding:18px;box-shadow:0 2px 8px rgba(0,0,0,.07);position:sticky;top:72px">
            <h3 style="font-family:Georgia,serif;font-size:16px;font-weight:700;margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid #C0392B">Settings</h3>

            <div class="form-group">
                <label class="form-label">Category *</label>
                <select name="category" form="articleForm" class="form-input">
                    @foreach(['nepal','australia','community','business','sports','entertainment','opinion','culture'] as $cat)
                    <option value="{{ $cat }}" {{ old('category', $article?->category ?? 'nepal') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Tags</label>
                <input type="text" name="tags" form="articleForm" class="form-input"
                       placeholder="nepal, education, visa"
                       value="{{ old('tags', $article?->tag_list ?? '') }}">
                <div style="font-size:11px;color:#999;margin-top:3px">Comma separated</div>
            </div>

            <div class="form-group">
                <label class="form-label">Language</label>
                <select name="language" form="articleForm" class="form-input">
                    <option value="en" {{ old('language', $article?->language ?? 'en') === 'en' ? 'selected' : '' }}>English</option>
                    <option value="ne" {{ old('language', $article?->language ?? 'en') === 'ne' ? 'selected' : '' }}>Nepali</option>
                </select>
            </div>

            @if(auth()->user()->isEditor())
            <div style="border-top:1px solid #e0dbd5;padding-top:14px;margin-top:4px">
                <label style="display:flex;align-items:center;gap:8px;margin-bottom:10px;cursor:pointer;font-size:14px">
                    <input type="checkbox" name="is_featured" form="articleForm" value="1" {{ old('is_featured', $article?->is_featured) ? 'checked' : '' }}>
                    ⭐ Featured (hero section)
                </label>
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:14px">
                    <input type="checkbox" name="is_breaking" form="articleForm" value="1" {{ old('is_breaking', $article?->is_breaking) ? 'checked' : '' }}>
                    🔴 Breaking news ticker
                </label>
            </div>
            @endif

            <div style="background:#f3f4f6;border-radius:3px;padding:12px;margin-top:14px;border:1px solid #e0dbd5">
                <div style="font-size:11px;color:#999;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px">Author</div>
                <div style="font-size:14px;font-weight:700;color:#1A252F">{{ auth()->user()->name }}</div>
                <span style="background:#C0392B;color:white;font-size:10px;padding:2px 8px;border-radius:20px;display:inline-block;margin-top:4px;text-transform:capitalize">{{ auth()->user()->role }}</span>
            </div>

            @if(isset($article) && $article && auth()->user()->isAdmin())
            <form method="POST" action="{{ route('articles.destroy',$article) }}" onsubmit="return confirm('Delete?')" style="margin-top:14px">
                @csrf @method('DELETE')
                <button class="btn-danger btn-sm" style="width:100%;font-size:12px"><i class="fa-solid fa-trash"></i> Delete Article</button>
            </form>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function setStatus(s) {
    document.getElementById('statusInput').value = s;
    document.getElementById('articleForm').submit();
}
const area = document.getElementById('contentArea');
if (area) {
    area.addEventListener('input', function() {
        const words = this.value.replace(/<[^>]*>/g,'').trim().split(/\s+/).filter(Boolean).length;
        document.getElementById('wordCount').textContent = words + ' words · ~' + Math.max(1,Math.round(words/200)) + ' min read';
    });
}
</script>
@endpush
@endsection
