<div class="panel panel-primary">
    <div class="panel-heading">
        <a href="<?php echo base_url('dashboard/accounts/new') ?>" class="label label-primary"><i class="fa fa-plus"></i> Add New</a>
    </div>
    <div class="panel-body">
        <?php
        //If any data available of the current month.
        if ($last_month == (int)date('m')) {
        ?>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Date</th>
                </tr>
            <?php
            foreach ($rows as $row) {
                if($row->amount != 0) {
                ?>
                <tr>
                    <td><?php echo $row->name; ?></td>
                    <td><?php echo $row->amount; ?></td>
                    <td><?php echo $row->created_at; ?></td>
                </tr>
            <?php }} ?>
        </table>
<?php } else {
           echo '<h4 style="color:red; text-align: left;">Please click (Add New) to add your cash</h4>';
}?>
    </div>
</div>
