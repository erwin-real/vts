@extends('layouts.app')
@section('title', 'View all tickets')
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">

            <div class="card-header ">
                <h5 class="float-left">
                    {{ (Auth::user()->type == 'supervisor') ? $user->department['name'] : '' }} {{ucfirst(trans($type))}} Ticket Reports </h5>
                @if(count($tickets) > 0)
                    <a href="/reports/export?type={{$type}}" target="_blank" class="btn btn-outline-success float-right">EXPORT</a>
                @endif
                <div class="clearfix"></div>
            </div>

            <div class="card-body mt-2">
                @if(count($tickets) == 0)
                    <h3 class="text-center">No tickets yet.</h3>
                    <p> There is no ticket.</p><a href="/tickets/create" class="btn btn-outline-primary">Create Ticket</a>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total Tickets</th>
                                <th>Solved</th>
                                <th>Pending</th>
                                <th>Show</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php
                                    foreach($tickets as $ticket) {
                                        $count = 0;
                                        $pending = 0;
                                        $ids="";

                                        foreach($ticket as $item) {
                                            if($item->department['name'] == $user->department['name'] || $user->type == 'admin') {
                                                echo '<tr><td>';
                                                if ($type == 'weekly') echo 'Week ';
                                                echo date($format, strtotime($item->created_at)).'</td>';
                                                break;
                                            }
                                        }

                                        foreach($ticket as $item){
                                            if($item->department['name'] == $user->department['name'] || $user->type == 'admin') {
                                                $count+=1;
                                                $pending += $item->status;
                                                $ids = $ids . $item->id.',';
                                            }
                                        }

                                        if ($count > 0) echo '<td>'. $count .'</td><td>'. $pending .'</td><td>'. ($count-$pending) .'</td>';

                                        if ($count > 0 && $ids > 0) {
                                            echo
                                                '<td>
                                                    <form action="/reports/show" method="GET">
                                                        <input type="hidden" name="type" value="'.$type.'">
                                                        <input type="hidden" name="tickets" value="'.$ids.'">
                                                        <input type="hidden" name="date" value="'.date($format, strtotime($ticket[0]->created_at)).'">
                                                        <input type="submit" class="btn btn-outline-primary" value="show">
                                                    </form>
                                                </td>
                                            </tr>';
                                        }
                                    }
                                @endphp
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>

@endsection