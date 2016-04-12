@extends('customer.layout.app')
@section('content')
    <div style="margin-top: 20px;" class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-info">
                    <div class="box-header">
                        Registration
                    </div>
                    <div class="box-body">

                        @if(Session::has('global'))
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="fa fa-check-square-o"></i> {{ Session::get('global') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/customer/register/create') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">First Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}">

                                    @if ($errors->has('firstname'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('firstname') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}">

                                    @if ($errors->has('lastname'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('companyname') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Company Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="companyname" value="{{ old('companyname') }}">

                                    @if ($errors->has('companyname'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('companyname') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Address</label>

                                <div class="col-md-6">
                                    <textarea class="form-control" name="address">{{ old('address') }}</textarea>

                                    @if ($errors->has('address'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('postal_code') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Postal Code</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="postal_code" value="{{ old('postal_code') }}">

                                    @if ($errors->has('postal_code'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('postal_code') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">City</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="city" value="{{ old('city') }}">

                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label">Phone Number</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">

                                    @if ($errors->has('phone'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i>Register
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
