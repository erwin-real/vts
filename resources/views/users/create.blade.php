@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create User') }}</div>

                    <div class="card-body">

                        @if (!empty($error))
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endif
                        @if (!empty($success))
                            <div class="alert alert-success">
                                {{ $success }}
                            </div>
                        @endif

                        <form method="POST" action="/users">
                            @csrf

                            <div class="form-group row">
                                <label for="fname" class="col-md-5 col-form-label text-md-right">{{ __('First Name') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="fname" type="text" class="form-control{{ $errors->has('fname') ? ' is-invalid' : '' }}" name="fname" value="{{ old('fname') }}" required autofocus>

                                    @if ($errors->has('fname'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('fname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mname" class="col-md-5 col-form-label text-md-right">{{ __('Middle Name') }}</label>

                                <div class="col-md-6">
                                    <input id="mname" type="text" class="form-control{{ $errors->has('mname') ? ' is-invalid' : '' }}" name="mname" value="{{ old('mname') }}" autofocus>

                                    @if ($errors->has('mname'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="lname" class="col-md-5 col-form-label text-md-right">{{ __('Last Name') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="lname" type="text" class="form-control{{ $errors->has('lname') ? ' is-invalid' : '' }}" name="lname" value="{{ old('lname') }}" required autofocus>

                                    @if ($errors->has('lname'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('lname') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="username" class="col-md-5 col-form-label text-md-right">{{ __('Username') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required>

                                    @if ($errors->has('username'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-5 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-5 col-form-label text-md-right">{{ __('Password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-5 col-form-label text-md-right">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dept" class="col-md-5 col-form-label text-md-right">{{ __('Department') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <select class="form-control" name="dept_id">
                                        @foreach($depts as $dept)
                                            <option value="{{$dept->id}}">{{$dept->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="ml-3 form-group row text-center">
                                <label class="col-12">
                                    <input type="checkbox" name="supervisor" > Supervisor
                                </label>
                            </div>

                            <div class="form-group row mb-0 text-center">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Add') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
