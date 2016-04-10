@extends('customer.layout.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="box box-info">
                    <div class="box-body">
                        @if(Session::has('global'))
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="alert alert-success alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                        <i class="fa fa-envelope-o"></i> {{ Session::get('global') }}
                                        <p><a href="{{ url('/customer/login') }}"></a></p>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
