<?php
// app/Http/Controllers/AdvertisementController.php
namespace App\Http\Controllers;
use App\Models\Advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    // List all ads (admin only)
    public function index() {
        if (!auth()->user()->isAdmin()) abort(403);
        $ads = Advertisement::with('creator')->latest()->paginate(20);
        return view('admin.ads', compact('ads'));
    }

    // Show create form
    public function create() {
        if (!auth()->user()->isAdmin()) abort(403);
        return view('admin.ad-form', ['ad' => null]);
    }

    // Store new ad
    public function store(Request $request) {
        if (!auth()->user()->isAdmin()) abort(403);
        $v = $request->validate([
            'title'     => 'required|max:200',
            'position'  => 'required|in:sidebar_top,sidebar_middle,sidebar_bottom,header_banner,article_inline,homepage_banner',
            'type'      => 'required|in:image,code,text',
            'image_url' => 'nullable|url',
            'link_url'  => 'nullable|url',
            'ad_code'   => 'nullable|string',
            'alt_text'  => 'nullable|max:200',
            'starts_at' => 'nullable|date',
            'ends_at'   => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'boolean',
        ]);
        Advertisement::create([...$v, 'created_by' => auth()->id()]);
        return redirect()->route('ads.index')->with('success','Advertisement created!');
    }

    // Edit form
    public function edit(Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        return view('admin.ad-form', compact('ad'));
    }

    // Update
    public function update(Request $request, Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        $v = $request->validate([
            'title'     => 'required|max:200',
            'position'  => 'required|in:sidebar_top,sidebar_middle,sidebar_bottom,header_banner,article_inline,homepage_banner',
            'type'      => 'required|in:image,code,text',
            'image_url' => 'nullable|url',
            'link_url'  => 'nullable|url',
            'ad_code'   => 'nullable|string',
            'alt_text'  => 'nullable|max:200',
            'starts_at' => 'nullable|date',
            'ends_at'   => 'nullable|date',
        ]);
        $ad->update([...$v, 'is_active' => $request->boolean('is_active')]);
        return redirect()->route('ads.index')->with('success','Advertisement updated!');
    }

    // Toggle active/inactive
    public function toggle(Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        $ad->update(['is_active' => !$ad->is_active]);
        return back()->with('success', $ad->is_active ? 'Ad activated!' : 'Ad deactivated!');
    }

    // Delete
    public function destroy(Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        $ad->delete();
        return redirect()->route('ads.index')->with('success','Ad deleted.');
    }

    // Track click (AJAX)
    public function click(Advertisement $ad) {
        $ad->incrementClicks();
        return response()->json(['success' => true]);
    }
}
