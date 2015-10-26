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

        <div class="panel panel-default">
            <div class="panel-heading">
                Create User Panel
            </div>

            <div class="panel-body">
                <form>
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
                <table class="table table-striped">
                    <tr><th>Mess Name</th><th>Password</th>/tr>
                    <?php
                        if(isset($rows)) {
                        foreach($rows as $row) {
                    ?>
                    <tr>
                        <td>
                            <?php echo $row-> mess_name;?>
                        </td>
                        <td></td>
                    </tr>

                    <?php }}?>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
   $(document).ready(function() {
        $(".btn-info").click(function() {
           var mess_name = $('#mess_name').val();
            var password = $('#password').val();
            $.post("<?php echo base_url('dashboard/userpanel/new');?>", {mess_name: mess_name, password: password}, function(data) {
                $("#error").html(data);
            })
        });
   })
</script>
