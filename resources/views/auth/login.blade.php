<x-guest-layout>
<h2 style="font-family:Georgia,serif;font-size:22px;font-weight:700;color:#1A252F;margin-bottom:4px;text-align:center">Sign In</h2>
<p style="color:#666;font-size:13px;text-align:center;margin-bottom:24px">Welcome back</p>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
        @error('email')<div style="color:#C0392B;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" placeholder="Your password" required>
        @error('password')<div style="color:#C0392B;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
    </div>
    <label style="display:flex;align-items:center;gap:8px;font-size:14px;margin-bottom:20px;cursor:pointer;color:#555">
        <input type="checkbox" name="remember"> Remember me
    </label>
    <button type="submit" class="btn-primary" style="width:100%;padding:12px;font-size:15px">Sign In →</button>
</form>
<p style="text-align:center;font-size:13px;color:#666;margin-top:18px">
    No account? <a href="{{ route('register') }}" style="color:#C0392B;font-weight:600">Register free</a>
</p>
<div style="margin-top:20px;padding:14px;background:#fffbf0;border:1px dashed #f0d9b5;border-radius:4px;font-size:12px;color:#666">
    <strong style="color:#856404;display:block;margin-bottom:6px">Demo credentials (password: admin123)</strong>
    admin@nepalnews.com.au &nbsp;|&nbsp; editor@nepalnews.com.au &nbsp;|&nbsp; contributor@nepalnews.com.au
</div>
</x-guest-layout>
