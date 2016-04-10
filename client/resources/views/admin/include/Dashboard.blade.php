@extends('admin.layout.index')
@section('header')
    Dashboard
@endsection

@section('content')

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">New Customer</span>
                <span class="info-box-number">{{ $new_customer }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Customer</span>
                <span class="info-box-number">{{ $total_customer }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Active Customer</span>
                <span class="info-box-number">{{ $active }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Inactive Customer</span>
                <span class="info-box-number">{{ $inactive }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Never Expired</span>
                <span class="info-box-number">{{ $never_expired}}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
@endsection