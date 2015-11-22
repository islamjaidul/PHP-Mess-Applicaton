<div class="row">
    <div class="col-md-6">
        <?php
        if (isset($_SESSION['msg'])) {
            ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['msg']; ?>
            </div>
        <?php } ?>

        <?php
        if (validation_errors()) {
            ?>
            <div class="alert alert-danger">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <span id="error"> </span>

        <div class="panel panel-primary">
            <div class="panel-heading">
                Create User Panel
            </div>

            <div class="panel-body">
                <?php echo form_open('dashboard/userpanel/new')?>
                <input type="text" name="mess_name" id="mess_name" class="form-control" placeholder="Enter the Mess Name" value="<?php echo set_value('mess_name')?>">
                <input type="password" name="password" id="password" class="form-control" placeholder="Enter the Password">
                <input style="width:300px" type="submit" class="btn btn-info" name="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">User Panel Information</div>
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
                                    <tr><th>Mess Name</th><th>Date</th></tr>
                         <?php
                            foreach ($rows as $row) {
                        ?>
                                    <tr>
                                        <td><?php echo $row->username; ?></td>
                                        <td><?php echo $row->created_at; ?></td>
                                    </tr>
                            <?php } ?>
                        </table>
                    <?php } else {
                        echo '<div class="alert alert-danger">You can add your user panel</div>';
                    }

                    ?>
            </div>
        </div>
    </div>
</div>

