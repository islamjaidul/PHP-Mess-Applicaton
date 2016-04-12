@extends('admin.layout.index')
@section('header')
    Setting
@endsection

@section('content')
    <style>
        .form-control{
            width:300px;
        }
    </style>
    <div class="box box-info">
        <div class="box-header">Password Setting</div>
        <div class="box-body">

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/dashboard/setting/change') }}">
                {!! csrf_field() !!}

                <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">Old Password</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="old_password" value="{{ old('old_password') }}">

                        @if ($errors->has('old_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('old_password') }}</strong>
                             </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label">New Password</label>

                    <div class="col-md-6">
                        <input type="password" class="form-control" name="new_password" value="{{ old('new_password') }}">

                        @if ($errors->has('new_password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('new_password') }}</strong>
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

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-pencil-square-o"></i> Change
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection