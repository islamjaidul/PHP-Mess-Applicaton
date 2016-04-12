@extends('admin.layout.index')
@section('header')
    Dashboard
@endsection

@section('content')
    @include('admin.include.registration')

        <!--New admin registration message start-->
    <span ng-if="customer == 'success'">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-check"></i> Registration completed
            </div>
         </span>
    <!--New admin registration message end-->

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">New Customers</span>
                <span class="info-box-number">{{ $new_customer }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Customers</span>
                <span class="info-box-number">{{ $total_customer }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Active Customers</span>
                <span class="info-box-number">{{ $active }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Inactive Customers</span>
                <span class="info-box-number">{{ $inactive }}</span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $("#registerSubmit").click(function(event) {
                event.preventDefault();
                $("#confirm-register").modal("hide");
            })
        })
    </script>
@endsection