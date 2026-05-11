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
use App\Models\{Article, Event, User};

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();
        $stats = [
            'total'     => $user->isEditor() ? Article::count()                               : $user->articles()->count(),
            'published' => $user->isEditor() ? Article::where('status','published')->count()   : $user->articles()->where('status','published')->count(),
            'drafts'    => $user->isEditor() ? Article::where('status','draft')->count()       : $user->articles()->where('status','draft')->count(),
            'views'     => $user->isEditor() ? (int)Article::sum('views')                     : (int)$user->articles()->sum('views'),
        ];
        $articles      = $user->isEditor() ? Article::with('author','tags')->latest()->paginate(20) : $user->articles()->with('author','tags')->latest()->paginate(20);
        $pendingEvents = $user->isEditor()  ? Event::where('is_approved',false)->with('creator')->latest()->get() : collect();
        $users         = $user->isAdmin()   ? User::latest()->paginate(30) : collect();
        return view('admin.dashboard', compact('stats','articles','pendingEvents','users'));
    }
}
