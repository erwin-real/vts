@extends('layouts.app')
@section('title', 'Home')

@section('content')
    <div class="container">
        <div class="row banner">

            <div class="col-md-12">

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <h1 class="text-center mt-5">
                    Vuuzle Ticketing System
                </h1>

            </div>

        </div>
    </div>
@endsection