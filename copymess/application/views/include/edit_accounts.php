<?php
if (validation_errors()) {
    ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php } ?>

<?php echo form_open('dashboard/accounts/edit') ?>
<?php
    foreach($rows as $row) {

?>
<input type="number" name="amount" class="form-control" value="<?php echo $row->amount;?>" placeholder="Enter the Amount">
<select name="memberid" class="form-control">
    <option value="0" selected="Select">Select Member</option>

        <option value="<?php echo $row->member_id ?>" selected="<?php echo $row->name;?>"><?php echo $row->name; ?></option>
</select>
        <input type="hidden" name="id" value="<?php echo $row->id;?>">
<input style="width: 300px;" type="submit" class="btn btn-info" name="submit" value="Submit">

<?php }?>