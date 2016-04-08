@extends('admin.layout.index')
@section('header')
    Customer Panel
@endsection
@section('content')
    @include('admin.common.cusomer_create')
    @include('admin.common.customer_information_view')
    @include('admin.common.customer_edit')
    @include('admin.common.activation_confirm')
    @include('admin.common.customer_live')

    <div class="box box-info">
        <!--Email error message start-->
         <span ng-if="customer == 'false'">
            <div class="alert alert-danger alert-dismissable">
                <button type="button" ng-click="dataFetch()" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-exclamation-triangle"></i> Email has been taken. Please choose another
            </div>
         </span>
        <!--Email error message end-->

        <div class="box-body">
            <a data-toggle="modal" data-target="#confirm-create" href="#"  class="label label-success"><i class="fa fa-user-plus"></i> Add New</a>
            <input style="float:right;  width:200px; margin-bottom:15px" type="text" class="form-control" placeholder="Search.." ng-model="search">

            <!--If not email error start-->
         <span ng-if="customer != 'false'">
            <table class="table table-bordered">
                <tr><th>Ref ID</th><th>First Name</th><th>Action</th><th>Starting Date</th><th>Ending Date</th><th>Status</th></tr>
                <tr ng-repeat="row in customer|filter: search">
                    <td>@{{ row.reference_id }}</td>
                    <td>@{{ row.firstname }}</td>
                    <td>
                        <a data-toggle="modal" data-target="#confirm-active" href="#" ng-if="row.active == 0" ng-click="activationId(row.id)" class="label label-warning">Accept</a>
                        <a href="#" ng-if="row.active == 1" ng-click="block(row.id)" class="label label-danger">Block</a>
                        <a href="#" ng-if="row.active == 0" ng-click="delete(row.id)" class="label label-danger">Deny</a>
                        <a data-toggle="modal" data-target="#confirm-edit" href="#" ng-click="view(row.id)" class="label label-primary">Edit</a>
                        <a data-toggle="modal" data-target="#confirm-view" href="#" ng-click="view(row.id)" class="label label-info">View</a>
                        <a data-toggle="modal" data-target="#confirm-live" ng-if="row.active == 1" href="#" ng-click="activationId(row.id)"  class="label label-success">Live</a>
                    </td>
                    <td ng-if="row.start_at == '0000-00-00'">---</td>
                    <td  ng-if="row.start_at != '0000-00-00'">@{{ row.start_at }}</td>
                    <td ng-if="row.end_at == '0000-00-00' && row.never_expired != 1">---</td>
                    <td style="color:green" ng-if="row.never_expired == '1'">Never Expired</td>
                    <td ng-if="row.end_at != '0000-00-00'">@{{ row.end_at }}</td>
                    <td>
                        <span style="width: 50px; display:block" ng-if="row.active == 1" class="label label-success">Active</span>
                        <span ng-if="row.active == 0" class="label label-danger">Inactive</span>
                    </td>
                </tr>
            </table>
         </span>
            <!--If not email error end-->
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $("#submit").click(function(event) {
                event.preventDefault();
                $("#confirm-create").modal("hide");
            })
            $("#editSubmit").click(function(event) {
                event.preventDefault();
                $("#confirm-edit").modal("hide");
            })
            $("#yesSubmit").click(function(event) {
                event.preventDefault();
                $("#confirm-active").modal("hide");
            })
            $("#noSubmit").click(function(event) {
                event.preventDefault();
                $("#confirm-active").modal("hide");
            })
            $("#liveSubmit").click(function(event) {
                event.preventDefault();
                $("#confirm-live").modal("hide");
            })
        })
    </script>
@endsection


