<?php
if (isset($_SESSION['msg'])) {
    ?>
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <i class="fa fa-check-square-o"></i>
    <?php echo $_SESSION['msg']; ?>
</div>
<?php } ?>

<?php
if (validation_errors()) {
    ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php
        echo validation_errors('<i class="fa fa-exclamation-triangle"></i>');
        ?>
    </div>
<?php } ?>

<?php echo form_open('dashboard/accounts/new') ?>
<input type="number" name="amount" class="form-control" value="<?php echo set_value('amount');?>" placeholder="Enter the Amount">
<select name="memberid" class="form-control">
    <option value="0" selected="Select">Select Member</option>
    <?php
    foreach ($rows as $row) {
        ?>
        <option name="options[]" value="<?php echo $row->id ?>"><?php echo $row->name; ?></option>
    <?php } ?>
</select>
<input style="width: 300px;" type="submit" class="btn btn-info" name="submit" value="Submit">
