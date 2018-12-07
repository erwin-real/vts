<?php

namespace App\Http\Controllers;

use App\Department;
use App\User;
use App\Ticket;
use App\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\TicketFormRequest;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function __construct()     {
        $this->middleware('auth');
    }

    public function index() {
        return view('tickets.index')
            ->with('tickets', Ticket::orderBy('created_at', 'desc')->paginate(20));
    }

    public function create() {
        return view('tickets.create')
            ->with('depts', Department::all());
    }

    public function store(TicketFormRequest $request) {
        $slug = uniqid();
        $ticket = new Ticket(array(
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'slug' => $slug,
            'department_id' => $request->get('dept_id'),
            'user_id' => auth()->user()->id
        ));

        $ticket->save();

        return redirect('/tickets')
            ->with('status', 'Your ticket has been created! Its unique id is: '.$slug);
    }

    public function show($slug) {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $comments = $ticket->comments()->get();
        return view('tickets.show')
            ->with('ticket', $ticket)
            ->with('comments', $comments);
    }

    public function edit($slug) {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        if($this->auth($slug) || (auth()->user()->department['name'] == $ticket->department['name'] && auth()->user()->type == 'supervisor')) {
            return view('tickets.edit')
                ->with('ticket', $ticket)
                ->with('depts', Department::all());
        }

        return redirect('/tickets')
            ->with('error', 'You don\'t have the privilege to update that ticket')
            ->with('tickets', Ticket::where('user_id', auth()->user()->id)->get());
    }

    public function update($slug, Request $request) {
        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        if($this->auth($slug) || (auth()->user()->department['name'] == $ticket->department['name'] && auth()->user()->type == 'supervisor')) {
            $ticket->title = $request->get('title');
            $ticket->content = $request->get('content');
            $ticket->department_id = $request->get('dept_id');
            if($request->get('status') != null) {
                if ($ticket->status != 0) $ticket->solved_at = Carbon::now();
                $ticket->status = 0;
            }
            else {
                $ticket->status = 1;
                $ticket->solved_at = null;
            }

            $ticket->save();
            return redirect(action('TicketController@index'))->with('status', 'The ticket '.$slug.' has been updated!');
        }
        
        return redirect('/tickets')
            ->with('error', 'You don\'t have the privilege to update that ticket')
            ->with('tickets', Ticket::where('user_id', auth()->user()->id)->get());
    }

    public function destroy($slug) {
        Ticket::where('user_id', auth()->user()->id)->get();

        $ticket = Ticket::whereSlug($slug)->firstOrFail();
        $comments = Comment::where('post_id', $ticket->id)->get();
        
        foreach($comments as $comment) $comment->delete();
        
        $ticket->delete();

        return redirect('/tickets')->with('status', 'The ticket '.$slug.' has been deleted!');
    }

    public function auth($slug) {
        $user = User::find(auth()->user()->id);
        if($user->type == 'admin' || $user->id == Ticket::whereSlug($slug)->firstOrFail()->user_id) return true;
        return false;
    }
}
