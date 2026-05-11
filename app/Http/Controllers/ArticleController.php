<?php
/**
 * Nepal News Australia
 * CPRO306 Capstone Project — Team 9
 * Kent Institute Australia — Skillup Labs WIL Program
 *
 * @author  Shushil Shah Teli (K231666) — Tech Lead & Backend Developer
 * @author  Subash Khatri (K250035)    — QA Engineer & DevOps
 * @author  Sujan Shrestha (K250040)   — Product Manager & Frontend
 * @version 1.0.0
 */

namespace App\Http\Controllers;
use App\Models\{Article, Tag};
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function show(string $slug) {
        $article = Article::published()->with('author','tags','comments')->where('slug',$slug)->firstOrFail();
        $article->incrementViews();
        $related = Article::published()->byCategory($article->category)->where('id','!=',$article->id)->with('author')->latest('published_at')->take(4)->get();
        return view('pages.article', compact('article','related'));
    }

    public function category(Request $request, string $cat = 'all') {
        $query = Article::published()->with('author','tags');
        if ($cat !== 'all') $query->byCategory($cat);
        if ($request->filled('search')) $query->search($request->search);
        if ($request->filled('tag')) $query->whereHas('tags', fn($q) => $q->where('slug',$request->tag));
        $articles   = $query->latest('published_at')->paginate(12)->withQueryString();
        $categories = ['all'=>'All News','nepal'=>'Nepal','australia'=>'Australia','community'=>'Community','business'=>'Business','sports'=>'Sports','entertainment'=>'Entertainment','opinion'=>'Opinion','culture'=>'Culture'];
        $trending   = Article::published()->orderByDesc('views')->take(5)->get();
        return view('pages.category', compact('articles','cat','categories','trending'));
    }

    public function create()  { $article = null; return view('admin.article-form', compact('article')); }

    public function store(Request $request) {
        $v = $request->validate(['title'=>'required|max:200','summary'=>'required|max:500','content'=>'required','category'=>'required|in:nepal,australia,community,business,sports,entertainment,opinion,culture','featured_image'=>'nullable|url','language'=>'nullable|in:en,ne']);
        $status = $request->input('status','draft');
        if (!auth()->user()->isEditor() && $status === 'published') $status = 'pending';
        $article = Article::create([...$v,'author_id'=>auth()->id(),'status'=>$status,'is_featured'=>$request->boolean('is_featured'),'is_breaking'=>$request->boolean('is_breaking'),'published_at'=>$status==='published'?now():null]);
        $this->syncTags($article,$request->tags);
        return redirect()->route('dashboard')->with('success', $status==='published'?'Published!':($status==='pending'?'Submitted for review!':'Draft saved!'));
    }

    public function edit(Article $article) {
        if (!auth()->user()->isEditor() && $article->author_id !== auth()->id()) abort(403);
        return view('admin.article-form', compact('article'));
    }

    public function update(Request $request, Article $article) {
        if (!auth()->user()->isEditor() && $article->author_id !== auth()->id()) abort(403);
        $v = $request->validate(['title'=>'required|max:200','summary'=>'required|max:500','content'=>'required','category'=>'required|in:nepal,australia,community,business,sports,entertainment,opinion,culture','featured_image'=>'nullable|url','language'=>'nullable|in:en,ne']);
        $status = $request->input('status',$article->status);
        if (!auth()->user()->isEditor() && $status==='published') $status='pending';
        $article->update([...$v,'status'=>$status,'is_featured'=>$request->boolean('is_featured'),'is_breaking'=>$request->boolean('is_breaking'),'published_at'=>$status==='published'&&!$article->published_at?now():$article->published_at]);
        $this->syncTags($article,$request->tags);
        return redirect()->route('dashboard')->with('success','Article updated!');
    }

    public function publish(Article $article) {
        if (!auth()->user()->isEditor()) abort(403);
        $article->update(['status'=>'published','published_at'=>now()]);
        return back()->with('success','Article published!');
    }

    public function destroy(Article $article) {
        if (!auth()->user()->isAdmin()) abort(403);
        $article->tags()->detach();
        $article->delete();
        return redirect()->route('dashboard')->with('success','Article deleted.');
    }

    private function syncTags(Article $article, ?string $tags): void {
        if (!$tags) return;
        $ids = [];
        foreach (explode(',',$tags) as $name) {
            $name = trim($name);
            if ($name) $ids[] = Tag::firstOrCreate(['slug'=>Str::slug($name)],['name'=>ucfirst($name)])->id;
        }
        $article->tags()->sync($ids);
    }
}
