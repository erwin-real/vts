@extends('layouts.app')
@section('title', 'View all tickets')
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">Users</h5>
                <a href="/users/create" class="btn btn-outline-primary float-right">Add User</a>
                <div class="clearfix"></div>
            </div>
            
            <div class="card-body mt-2">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (!empty($success))
                    <div class="alert alert-success">
                        {{ $success }}
                    </div>
                @endif
                @if ($users->isEmpty())
                    <p> There are no users yet.</p>
                @else
                    {{$users->links()}}
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email-address</th>
                                    <th>Username</th>
                                    <th>Department</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td><a href="/users/{{$user->id}}">{{ $user->fname }} {{ isset($user->mname) ? strtoupper($user->mname)[0].'.' : '' }} {{ $user->lname }}</a></td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->department['name'] }}</td>
                                        <td>{{ $user->type }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection