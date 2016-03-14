<div class="panel panel-primary">
    <div class="panel-heading">
        <a href="<?php echo base_url('dashboard/member/new') ?>" class="label label-primary"><i class="fa fa-plus"></i> Add New</a>
    </div>
    <div class="panel-body">
        <?php
        $id = 0;
        foreach ($rows as $row) {
            $id = $row->usersid;
            break;
        }
        if ($_SESSION['id'] == $id) {
            ?>
            <table class="table table-striped">
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Mobile</th>
                    <th>E-mail</th>
                    <th>Occupation</th>
                    <th>Action</th>
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
                        <td><a href="#" class="label label-info"><i class="fa fa-pencil-square-o"></i></a>  <a href="#" class="label label-danger"><i class="fa fa-trash"></i></a></td>
                    </tr>
                <?php } ?>
            </table>
        <?php } else {
            echo '<h4 style="color:red; text-align: left;">Please click (Add New) to add your mess member</h4>';
        }

        ?>
    </div>
</div>
