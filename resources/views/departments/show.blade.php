@extends('layouts.app')
{{-- @section('title', 'View a ticket') --}}
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5><strong>Name</strong>: {{ $dept->name }} Department</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <p> <strong>Supervisor/s</strong>:
                @if(isset($dept->supervisor[0]))
                    <ol>
                        @foreach($dept->supervisor as $supervisor)
                            <li>{{$supervisor->fname}} {{isset($supervisor->mname) ? strtoupper($supervisor->mname)[0].'.' : ''}} {{$supervisor->lname}}</li>
                        @endforeach
                    </ol>
                @else
                    none
                @endif
                <p> <strong>Members</strong>:
                @if(count($dept->members) > 0)
                    <ol>
                        @foreach($dept->members as $member)
                            <li>{{$member->fname}} {{$member->mname}} {{$member->lname}}</li>
                        @endforeach
                    </ol>
                @else
                    none
                @endif
                <html>
                <body></body>
                </html>
                <p> <strong>Description</strong>: {{ $dept->desc }} </p>
                <a href="{{ action('DepartmentController@edit', $dept->id) }}" class="btn btn-outline-info float-left mr-2">Edit</a>
                
                @if(Auth::user()->type == 'admin' || Auth::user()->id == $dept->user_id)
                    <form method="POST" action="{{ action('DepartmentController@destroy', $dept->id) }}" class="float-left">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div>
                            <button type="submit" class="btn btn-outline-primary margin-left float-right" >Delete</button>
                        </div>
                    </form>
                @endif
                <div class="clearfix"></div>
            </div>
        </div>

    </div>

@endsection