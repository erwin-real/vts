@extends('layouts.app')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="card mt-5">
            <div class="card-header ">
                <h5 class="float-left">Create a department</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body mt-2">
                <form action="{{ action('DepartmentController@store') }}" method="POST">
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
                            <label for="name" class="col-lg-12 control-label">Name <span class="text-muted font-italic"> (Don't add the word 'Department')</span></label>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" id="name" placeholder="Name of Department" name="name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-lg-12 control-label">Description</label>
                            <div class="col-lg-12">
                                <textarea class="form-control" rows="3" id="description" name="description"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection