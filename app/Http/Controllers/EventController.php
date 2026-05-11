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
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request) {
        $query = Event::approved()->upcoming()->with('creator');
        if ($request->filled('city'))     $query->where('city',$request->city);
        if ($request->filled('category')) $query->where('category',$request->category);
        $events = $query->orderBy('event_date')->paginate(12);
        return view('pages.events', compact('events'));
    }

    public function store(Request $request) {
        $v = $request->validate(['title'=>'required|max:200','description'=>'required','event_date'=>'required|date','venue'=>'required','city'=>'required|in:Sydney,Melbourne,Brisbane,Perth,Adelaide,Canberra,Other','organiser'=>'required']);
        Event::create([...$v,'created_by'=>auth()->id(),'is_approved'=>false,'is_free'=>$request->boolean('is_free',true),'ticket_price'=>$request->ticket_price??0]);
        return back()->with('success','Event submitted for approval!');
    }

    public function approve(Event $event) {
        if (!auth()->user()->isEditor()) abort(403);
        $event->update(['is_approved'=>true]);
        return back()->with('success','Event approved!');
    }
}
