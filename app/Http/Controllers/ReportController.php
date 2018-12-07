<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\User;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function template(Request $request) {
        if ($this->isUserType('admin') || $this->isUserType('supervisor')) {
            $type = ($request->input('type')) ? $request->input('type') : 'daily';
            $data = $this->getTicketsAndFormats($type);

            return view('reports.template')
                ->with('tickets', $data[0])
                ->with('type', $type)
                ->with('format', $data[1])
                ->with('user', User::find(auth()->user()->id));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function show(Request $request) {
        if ($this->isUserType('admin') || $this->isUserType('supervisor')) {
            return view('reports.show')
                ->with('tickets', Ticket::find(explode(',', $request->input('tickets'))))
                ->with('ticket_ids', $request->input('tickets'))
                ->with('date', $request->input('date'))
                ->with('type', $request->input('type'));
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function export(Request $request) {
        if ($this->isUserType('admin') || $this->isUserType('supervisor')) {
            $type = $request->input('type');
            $data = $this->getTicketsAndFormats($type);
            $tickets = $data[0];
            $format = $data[1];
            $pdf = PDF::loadView('reports.type',
                compact('type', 'tickets', 'format'));
            return $pdf->stream($type.'.pdf');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function each(Request $request) {
        if ($this->isUserType('admin') || $this->isUserType('supervisor')) {
            $tickets = Ticket::find(explode(',', $request->input('tickets')));
            $date = $request->input('date');
            $type = $request->input('type');
            $pdf = PDF::loadView('reports.each',
                compact('tickets', 'date', 'type'));
            return $pdf->stream($date.'.pdf');
        }
        return redirect('/')->with('error', 'You don\'t have the privilege');
    }

    public function isUserType($type) {
        if(User::find(auth()->user()->id)->type == $type) return true;
        return false;
    }

    public function getTicketsAndFormats($type) {
        $data = collect();
        if ($type == 'daily') {
            $data[0] = $this->daily();
            $data[1] = 'D M d, Y';
        } else if ($type == 'weekly') {
            $data[0] = $this->weekly();
            $data[1] = 'W, Y';
        } else if ($type == 'monthly') {
            $data[0] = $this->monthly();
            $data[1] = 'M Y';
        }

        return $data;
    }

    public function daily() {
        return Ticket::all()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('M d, Y'); // grouping by days
            });
    }

    public function weekly() {
        return Ticket::all()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('W Y'); // grouping by weeks with year
            });
    }

    public function monthly() {
        return Ticket::all()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('M Y'); // grouping by months
            });
    }
}
