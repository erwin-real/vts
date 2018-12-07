@extends('layouts.app')
@section('title', 'Edit a ticket')

@section('content')
    <div class="container col-md-8 col-md-offset-2">
        <div class="card mt-5">
            <div class="card-header ">
                <h5 class="float-left">Edit ticket</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body mt-2">
                <form action="{{ action('TicketController@update', $ticket->slug) }}" method="POST">
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
                            <label for="title" class="col-lg-12 control-label">Title</label>
                            <div class="col-lg-12">
                                <input type="text" class="form-control" id="title" placeholder="Title" name="title" value="{{ $ticket->title }}" {{(Auth::user()->id == $ticket->user_id) ? '' : 'readonly'}}>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-lg-12 control-label">Content</label>
                            <div class="col-lg-12">
                                @if(Auth::user()->id == $ticket->user_id)
                                    <textarea class="form-control" rows="3" id="content" name="content">{{ $ticket->content }}</textarea>
                                    <span class="help-block">Feel free to ask us any question.</span>
                                @else
                                    <textarea class="form-control" rows="3" id="content" name="content" readonly>{{ $ticket->content }}</textarea>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dept_id" class="col-lg-12 control-label">{{ __('For which department?') }} (<strong>{{$ticket->department['name']}}</strong> Department) <span class="text-danger">*</span></label>

                            <div class="col-md-6">
                                <select class="form-control" name="dept_id" {{ ((Auth::user()->id == $ticket->user_id) || (Auth::user()->type == 'admin') ? '' : 'disabled' )}}>
                                    @foreach($depts as $dept)
                                        <option value="{{$dept->id}}">{{$dept->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @if(Auth::user()->type == 'admin' || Auth::user()->type == 'supervisor')
                            <div class="ml-3 form-group">
                                <label>
                                    <input type="checkbox" name="status" {{ $ticket->status?"":"checked"}} > Close this ticket?
                                </label>
                            </div>
                        @endif
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection