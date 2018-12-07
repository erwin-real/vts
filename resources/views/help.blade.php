@extends('layouts.app')
@section('title', 'Help')
@section('content')

    <div class="container col-md-8 col-md-offset-2 mt-5">
        <div class="card">
            <div class="card-header ">
                <h5 class="float-left">Help</h5>
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
                    <p> <i class="fas fa-exclamation-triangle text-danger"></i> Work in progress .</p>
            </div>
        </div>
    </div>

@endsection