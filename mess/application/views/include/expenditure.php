<div class="panel panel-primary">
    <div class="panel-heading">
        <a href="<?php echo base_url('dashboard/expenditure/new') ?>" class="label label-primary"><i class="fa fa-plus"></i> Add New</a>
        <input ng-model = 'search' style="display: inline; float: right; margin-top:-7px; width: 200px" type="text" class="form-control" placeholder="search for daily expense">
    </div>
    <div ng-controller="MyController" class="panel-body">
        <?php

        if ($last_month == date('m')) { //$last_month comes from Controller
            ?>
            <table class="table table-striped">
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
                    <td>{{ x.name}}<td/>
                    <td>{{ x.expense_amount}}<td/>
                    <td>{{ x.shopping }}</td>
                    <td>{{ x.created_at }}</td>
                </tr>
            </table>
        <?php } else {
            echo '<h4 style="color:red; text-align: left;">Please click (Add New) to add your expenditure</h4>';
        }

        ?>
    </div>
</div>

