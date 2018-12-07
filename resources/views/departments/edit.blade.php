@extends('layouts.app')
@section('title', 'Edit a department')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="card mt-5">
            <div class="card-header ">
                <h5 class="float-left">{{ $dept->name }} Department</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body mt-2">
                <form action="{{ action('DepartmentController@update', $dept->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <fieldset>
                        <div class="form-group">
                            <label for="title" class="col-lg-12 control-label">Name</label>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="{{ $dept->name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-lg-12 control-label">Description</label>
                            <div class="col-lg-12">
                                <textarea class="form-control" rows="3" id="description" name="description">{{ $dept->desc }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                {{-- <button class="btn btn-default">Cancel</button> --}}
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection