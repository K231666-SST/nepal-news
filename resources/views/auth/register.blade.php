<x-guest-layout>
<h2 style="font-family:Georgia,serif;font-size:22px;font-weight:700;color:#1A252F;margin-bottom:4px;text-align:center">Create Account</h2>
<p style="color:#666;font-size:13px;text-align:center;margin-bottom:24px">Join the Nepali-Australian community</p>
<form method="POST" action="{{ route('register') }}">
    @csrf
    <div class="form-group">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-input" value="{{ old('name') }}" placeholder="Your full name" required autofocus>
        @error('name')<div style="color:#C0392B;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label class="form-label">Email Address</label>
        <input type="email" name="email" class="form-input" value="{{ old('email') }}" placeholder="you@example.com" required>
        @error('email')<div style="color:#C0392B;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-input" placeholder="Minimum 8 characters" required>
        @error('password')<div style="color:#C0392B;font-size:12px;margin-top:4px">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        <label class="form-label">Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-input" placeholder="Repeat password" required>
    </div>
    <button type="submit" class="btn-primary" style="width:100%;padding:12px;font-size:15px">Create Account →</button>
</form>
<p style="text-align:center;font-size:13px;color:#666;margin-top:18px">
    Already have an account? <a href="{{ route('login') }}" style="color:#C0392B;font-weight:600">Sign in</a>
</p>
</x-guest-layout>
