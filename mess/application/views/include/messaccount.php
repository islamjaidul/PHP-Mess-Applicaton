<div style="float:right" class="btn-group" role="group" aria-label="...">
    <a href="<?php echo base_url('dashboard/accounts/new') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add
        New</a>
    <button id="deleteall" class="btn btn-danger" type="submit"><i class="fa fa-trash-o"></i> Delete</button>
</div>

<?php
$id = 0;
foreach ($rows as $row) {
    $id = $row->usersid;
    break;
}
if ($_SESSION['id'] == $id) {
    ?>
    <table style="margin-top:50px;" class="table table-striped">
        <tr>
            <th>Name</th>
            <th>Amount</th>
            <th>Date</th>
        </tr>
        <?php
        foreach ($rows as $row) {
            ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->amount; ?></td>
                <td><?php echo $row->created_at; ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } else {
    echo '<div style="margin-top:50px" class="alert alert-danger">Please click add new to add new cash</div>';
}