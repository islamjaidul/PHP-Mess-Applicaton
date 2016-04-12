<div ng-controller="MyController">

    <!--Edit Div Start-->
    <div class="modal fade" id="confirm-delete">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Edit</h4>
                </div>

                <div class="modal-body">
                    <from ng-repeat="y in editData">
                        <select class="form-control" name="name">
                            <option value="" selected="Select">{{ y.name }}</option>
                        </select>
                        <input type="number" name="amount" class="form-control" placeholder="Enter Amount" value="{{y.expense_amount}}">
                        <textarea name="shopping" class="form-control" placeholder="Enter your shopping">{{ y.shopping }}</textarea>
                    </from>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a id="edit" href="#" class="btn btn-danger danger">Edit</a>
                </div>
            </div>
        </div>
    </div>
    <!--Edit Div End-->

    <div class="box box-info">
        <div class="box-body">
            <div style="margin-bottom:10px"><a href="<?php echo base_url('dashboard/expenditure/new') ?>" class="label label-success"><i class="fa fa-plus"></i> Add New</a></div>
            <input ng-model = 'search' style="display: inline; float: right; margin-top:-32px; width: 200px" type="text" class="form-control" placeholder="search for daily expense">
            <?php

            if ($last_month == date('m')) { //$last_month comes from Controller
                ?>
                <table class="table table-bordered">
                    <tr><th>Name</th><th>Amount</th><th>Shopping</th><th>Date</th><th>Action</th></tr>
                    <!--<?php
                    foreach ($rows as $row) {
                        ?>
                <tr>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->expense_amount; ?></td>
                    <td><?php echo $row->shopping; ?></td>
                    <td><?php echo $row->created_at; ?></td>
                </tr>
            <?php } ?>-->
                    <tr ng-repeat="x in author | filter: search">
                        <td>{{ x.name}}</td>
                        <td>{{ x.expense_amount}}</td>
                        <td>{{ x.shopping }}</td>
                        <td>{{ x.created_at }}</td>
                        <td><a data-toggle="modal" data-target="#confirm-delete" class="label label-info" ng-click="edit(x.id, x.usersid, x.month)"><i class="fa fa-pencil-square-o"></i></a>
                        <a class="label label-danger" href="#" ng-click="delete(x.id, x.usersid, x.month)"><i class="fa fa-trash"></i> </a></td>
                    </tr>
                </table>
            <?php } else {
                echo '<h4 style="color:red; text-align: left;">Please click (Add New) to add your expenditure</h4>';
            }

            ?>
        </div>
    </div>

</div>

