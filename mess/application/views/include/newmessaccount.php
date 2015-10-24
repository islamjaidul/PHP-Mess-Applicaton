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

<?php echo form_open('dashboard/accounts/new') ?>
<input type="number" name="amount" class="form-control" placeholder="Enter the Amount">
<select name="memberid" class="form-control">
    <option value="0" selected="Select">Select Member</option>
    <?php
    foreach ($rows as $row) {
        ?>
        <option value="<?php echo $row->id ?>"><?php echo $row->name; ?></option>
    <?php } ?>
</select>
<input style="width: 300px;" type="submit" class="btn btn-info" name="submit" value="Submit">
