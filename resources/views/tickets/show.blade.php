@extends('layouts.app')
{{-- @section('title', 'View a ticket') --}}
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5>
                    <strong>Title</strong>
                    : {{ $ticket->title }}
                    @if (!$ticket->status)
                        <i class="fas fa-check text-success"></i>
                    @endif
                </h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <p> <strong>Created by</strong>: {{ $ticket->user['fname'] }} {{isset($ticket->user['mname']) ? strtoupper($ticket->user['mname'])[0].'.' : ''}} {{ $ticket->user['lname'] }}</p>
                <p> <strong>From </strong>: {{ $ticket->user['department']->name }} Department</p>
                <p> <strong>For </strong>: {{ $ticket->department['name'] }} Department</p>
                <p> <strong>Status</strong>: {{ $ticket->status ? 'Pending' : 'Answered' }}</p>
                <p> <strong>Content</strong>: {{ $ticket->content }} </p>
                <p> <strong>Date Created</strong>: {{date('D M d,Y H:i', strtotime($ticket->created_at))}} </p>
                @if(!$ticket->status)
                    <p> <strong>Date Solved</strong>: {{date('D M d,Y H:i', strtotime($ticket->solved_at))}} </p>
                @endif

                @if(Auth::user()->type == 'admin' || Auth::user()->id == $ticket->user_id ||
                    ($ticket->department['name'] == Auth::user()->department['name'] && Auth::user()->type == 'supervisor'))
                    <a href="{{ action('TicketController@edit', $ticket->slug) }}" class="btn btn-outline-info float-left mr-2">Edit</a>

                    <form method="POST" action="{{ action('TicketController@destroy', $ticket->slug) }}" class="float-left">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div>
                            <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </div>
                    </form>
                @endif
                <div class="clearfix"></div>
            </div>
        </div>

        @if(count($comments) != 0)
            @foreach($comments as $comment)
                <div class="card mt-3">
                    <div class="card-body">
                        <p>{{ $comment->content }}</p>
                        <footer class="blockquote-footer">{{ $comment->user['fname'] }}, <cite title="Source Title">{{date('D M d,Y H:i', strtotime($comment->created_at))}}</cite></footer>
                    </div>
                </div>
            @endforeach
        @endif
        
        @if(Auth::user()->type == 'admin' || Auth::user()->id == $ticket->user_id)
            <div class="card mt-3">
                <form method="post" action="/comment">

                    @foreach($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach

                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="post_id" value="{{ $ticket->id }}">

                    <fieldset>
                        <legend class="ml-3">Reply</legend>
                        <div class="form-group">
                            <div class="col-lg-12">
                                <textarea class="form-control" rows="3" id="content" name="content"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                                <button type="submit" class="btn btn-outline-success">Post</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        @endif

    </div>

@endsection