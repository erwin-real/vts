@extends('layouts.app')
@section('title', 'View all tickets')
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">
                    {{ (Auth::user()->type == 'supervisor') ? Auth::user()->department['name'] : '' }} Tickets --
                    {{$type == 'weekly' ? 'Week ' : ''}} {{$date}}</h5>
                <a href="/reports/each?type={{$type}}&date={{$date}}&tickets={{$ticket_ids}}" target="_blank" class="btn btn-outline-success float-right">EXPORT</a>
                <div class="clearfix"></div>
            </div>
            
            <div class="card-body mt-2">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Created by</th>
                            <th>Created at</th>
                            <th>Department</th>
                            <th>Solved at</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $ticket)
                                @if($ticket->department['name'] == Auth::user()->department['name'] || Auth::user()->type == 'admin' || Auth::user()->id == $ticket->user['id'])
                                    <tr>
                                        <td>{{ $ticket->id }}</td>
                                        <td>
                                            <a href="{{ action('TicketController@show', $ticket->slug) }}">{{ $ticket->title }} </a>
                                        </td>
                                        <td>{{ $ticket->status ? 'Pending' : 'Solved' }}</td>
                                        <td>{{ $ticket->user['fname'] }} {{ $ticket->user['lname'] }}</td>
                                        <td>{{date('D M d,Y H:i', strtotime($ticket->created_at))}}</td>
                                        <td>{{ $ticket->department['name'] }}</td>
                                        <td>{{ ($ticket->solved_at != null) ? date('D M d,Y H:i', strtotime($ticket->solved_at)) : 'N/A' }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection