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

<?php echo form_open('dashboard/expenditure/new')?>
<select name="mess_memberid" class="form-control">
    <option value="0" selected="Select">Select Member</option>
    <?php
    foreach ($rows as $row) {
        ?>
        <option value="<?php echo $row->id ?>"><?php echo $row->name; ?></option>
    <?php } ?>
</select>

<input type="number" name="expense_amount" class="form-control" placeholder="Enter the Amount" value="<?php echo set_value('expense_amount');?>">
<textarea name="shopping" placeholder="Enter the Shopping Description" class="form-control"></textarea>
<input style="width:300px" type="submit" class="btn btn-info" value="Submit" name="Submit">
