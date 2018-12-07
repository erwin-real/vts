@extends('layouts.app')
@section('title', 'View all tickets')
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">Departments</h5>
                <div class="clearfix"></div>
            </div>
            
            <div class="card-body mt-2">
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($depts->isEmpty())
                    <p> There are no departments yet.</p>
                        <a href="/depts/create" class="btn btn-outline-primary">Create Department</a>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Supervisor/s</th>
                                    <th>Member/s</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($depts as $dept)
                                    <tr>
                                        <td>
                                            <a href="{{ action('DepartmentController@show', $dept->id) }}">{{ $dept->name }} </a>
                                        </td>
                                        @if(isset($dept->supervisor[0]))
                                            <td>
                                                @foreach($dept->supervisor as $supervisor)
                                                    {{$supervisor->fname}} {{isset($supervisor->mname) ? strtoupper($supervisor->mname)[0].'.' : ''}} {{$supervisor->lname}}
                                                    <br>
                                                @endforeach
                                            </td>
                                        @else
                                            <td>none</td>
                                        @endif
                                        <td>{{count($dept->members)}}</td>
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