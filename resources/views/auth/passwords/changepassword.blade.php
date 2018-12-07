@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Change password</div>

                    <div class="card-body">
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
                        <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}">
                            {{ csrf_field() }}

                            <div class="form-group row{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                <label for="current-password" class="col-md-6 col-form-label text-md-right">{{ __('Current Password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="current-password" type="password"
                                           class="form-control{{ $errors->has('current-password') ? ' is-invalid' : '' }}"
                                           name="current-password" value="{{ old('current-password') }}" required autofocus>

                                    @if ($errors->has('current-password'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                <label for="new-password" class="col-md-6 col-form-label text-md-right">{{ __('New Password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="new-password" type="password"
                                           class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}"
                                           name="new-password" value="{{ old('new-password') }}" required autofocus>

                                    @if ($errors->has('new-password'))
                                        <span class="help-block text-danger">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row{{ $errors->has('new-password-confirm') ? ' has-error' : '' }}">
                                <label for="new-password-confirm" class="col-md-6 col-form-label text-md-right">{{ __('Confirm New Password') }} <span class="text-danger">*</span></label>

                                <div class="col-md-6">
                                    <input id="new-password-confirm" type="password"
                                           class="form-control{{ $errors->has('new-password-confirm') ? ' is-invalid' : '' }}"
                                           name="new-password_confirmation" value="{{ old('new-password-confirm') }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-outline-primary">
                                        Change Password
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