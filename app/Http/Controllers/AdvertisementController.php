<?php
namespace App\Http\Controllers;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index() {
        if (!auth()->user()->isAdmin()) abort(403);
        $ads = Advertisement::with('creator')->latest()->paginate(20);
        return view('admin.ads', compact('ads'));
    }

    public function create() {
        if (!auth()->user()->isAdmin()) abort(403);
        return view('admin.ad-form', ['ad' => null]);
    }

    public function store(Request $request) {
        if (!auth()->user()->isAdmin()) abort(403);
        $v = $request->validate([
            'title'     => 'required|max:200',
            'position'  => 'required|in:sidebar_top,sidebar_middle,sidebar_bottom,header_banner,article_inline,homepage_banner',
            'type'      => 'required|in:image,code,text',
            'image_url' => 'nullable|url',
            'image_file'=> 'nullable|image|max:5120',
            'link_url'  => 'nullable|url',
            'ad_code'   => 'nullable|string',
            'alt_text'  => 'nullable|max:200',
            'starts_at' => 'nullable|date',
            'ends_at'   => 'nullable|date',
        ]);

        // Handle file upload
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('ads', 'public');
            $v['image_url'] = '/storage/' . $path;
        }

        Advertisement::create([...$v, 'is_active' => $request->boolean('is_active',true), 'created_by' => auth()->id()]);
        return redirect()->route('ads.index')->with('success','Advertisement created successfully!');
    }

    public function edit(Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        return view('admin.ad-form', compact('ad'));
    }

    public function update(Request $request, Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        $v = $request->validate([
            'title'     => 'required|max:200',
            'position'  => 'required|in:sidebar_top,sidebar_middle,sidebar_bottom,header_banner,article_inline,homepage_banner',
            'type'      => 'required|in:image,code,text',
            'image_url' => 'nullable|url',
            'image_file'=> 'nullable|image|max:5120',
            'link_url'  => 'nullable|url',
            'ad_code'   => 'nullable|string',
            'alt_text'  => 'nullable|max:200',
            'starts_at' => 'nullable|date',
            'ends_at'   => 'nullable|date',
        ]);

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('ads', 'public');
            $v['image_url'] = '/storage/' . $path;
        }

        $ad->update([...$v, 'is_active' => $request->boolean('is_active')]);
        return redirect()->route('ads.index')->with('success','Advertisement updated!');
    }

    public function toggle(Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        $ad->update(['is_active' => !$ad->is_active]);
        return back()->with('success', $ad->is_active ? 'Ad activated!' : 'Ad deactivated!');
    }

    public function destroy(Advertisement $ad) {
        if (!auth()->user()->isAdmin()) abort(403);
        $ad->delete();
        return redirect()->route('ads.index')->with('success','Ad deleted.');
    }

    public function click(Advertisement $ad) {
        $ad->incrementClicks();
        return response()->json(['success' => true]);
    }
}
