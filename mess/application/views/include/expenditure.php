<div class="panel panel-primary">
    <div class="panel-heading">
        <a href="<?php echo base_url('dashboard/expenditure/new') ?>" class="label label-primary"><i class="fa fa-plus"></i> Add New</a>
    </div>
    <div class="panel-body">
        <?php
        $id = 0;
        foreach ($rows as $row) {
            $id = $row->usersid; // $id is created for specify this unique id
            break;
        }
        if ($_SESSION['id'] == $id && $last_month == date('m')) { //$last_month comes from Controller
            ?>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Shopping</th>
                    <th>Date</th>
                </tr>
                <?php
                foreach ($rows as $row) {
                    ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->expense_amount; ?></td>
                        <td><?php echo $row->shopping; ?></td>
                        <td><?php echo $row->created_at; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {
            echo '<h4 style="color:red; text-align: left;">Please click (Add New) to add your expenditure</h4>';
        }

        ?>
    </div>
</div>
