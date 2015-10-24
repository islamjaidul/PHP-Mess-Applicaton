<div style="float:right" class="btn-group" role="group" aria-label="...">
    <a href="<?php echo base_url('dashboard/member/new') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add New</a>
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
            <th>Address</th>
            <th>Mobile</th>
            <th>E-mail</th>
            <th>Occupation</th>
        </tr>
        <?php
        foreach ($rows as $row) {
            ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->address; ?></td>
                <td><?php echo $row->mobile; ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->occupation; ?></td>
            </tr>
        <?php } ?>
    </table>
<?php } else {
    echo '<div style="margin-top:50px" class="alert alert-danger">Please click add new to add your mess member</div>';
}
?>