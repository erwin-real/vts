@extends('layouts.app')
{{-- @section('title', 'View a ticket') --}}
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5><strong>Name</strong>: {{ $user->fname }}</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <p> <strong>First Name</strong>: {{ $user->fname }}</p>
                <p> <strong>Middle Name</strong>: {{ $user->mname }}</p>
                <p> <strong>Last Name</strong>: {{ $user->lname }}</p>
                <p> <strong>Username</strong>: {{ $user->username }}</p>
                <p> <strong>Email</strong>: {{ $user->email }}</p>
                <p> <strong>Department</strong>: {{ $user->department['name'] }}</p>
                <p> <strong>Type</strong>: {{ $user->type }}</p>

                @if(Auth::user()->type == 'admin' || Auth::user()->id == $user->id)
                    <a href="{{ action('HomeController@editUser', $user->id) }}" class="btn btn-outline-info float-left mr-2">Edit</a>

                    <form method="POST" action="{{ action('HomeController@destroyUser', $user->id) }}" class="float-left">
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



    </div>

@endsection