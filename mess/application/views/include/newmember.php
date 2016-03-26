
<?php
if (isset($_SESSION['msg'])) {
    ?>
    <div class="alert alert-success">
        <i class="fa fa-check-square-o"></i> <?php echo $_SESSION['msg']; ?>
    </div>
<?php } ?>

<?php
if (validation_errors()) {
    ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php } ?>
<?php echo form_open('dashboard/member/new'); ?>
<input type="text" name="name" class="form-control" placeholder="Enter Your Name"
       value="<?php echo set_value('name') ?>">
<textarea name="address" class="form-control"
          placeholder="Enter Your Address"><?php echo set_value('address') ?></textarea>
<input type="text" name="mobile" class="form-control" placeholder="Enter Your Mobile Number"
       value="<?php echo set_value('mobile') ?>">
<input type="email" name="email" class="form-control" placeholder="Enter Your E-mail"
       value="<?php echo set_value('email') ?>">
<select name="occupation" class="form-control">
    <option value="0" selected="Select">Select</option>
    <option value="Student" <?php echo set_select('occupation', 'Student'); ?>>Student</option>
    <option value="Service" <?php echo set_select('occupation', 'Service'); ?>>Service</option>
</select>
<input style="width: 300px" type="submit" class="btn btn-info" name="submit" value="Submit">