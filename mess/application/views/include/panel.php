<div class="alert alert-success">Note: You can set your meal below</div>
<div class="col-md-4">
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


    <?php echo form_open('dashboard/panel')?>
        <select name="member" id="member" class="form-control">
            <option value="Select" selected="Select">Select</option>
            <?php
                foreach($rows as $row) {
                    echo '<option value="'.$row->id.'">'.$row->name.'</option>';
                }
            ?>
        </select>
        <input type="number" class="form-control" name="breakfast_meal" id="breakfast_meal" placeholder="Enter your Breakfast Meal">
        <input type="number" class="form-control" name="lunch_meal" id="lunch_meal" placeholder="Enter your Lunch Meal">
        <input type="number" class="form-control" name="dinner_meal" id="dinner_meal" placeholder="Enter your Dinner Meal">
        <input style="width:300px" type="submit" class="btn btn-info" value="Save">
    </form>

</div>

<div class="col-md-8">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Meal Panel
        </div>

        <div class="panel-body">
            Please select the member
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#member').change(function() {
            var id = $("#member").val();
            $.post("<?php echo base_url('ajax/Panel.php')?>", {id: id}, function(data) {
                $(".panel-body").html(data);
            })
            $(".panel-body").html('Loading...');
        })
    })
</script>