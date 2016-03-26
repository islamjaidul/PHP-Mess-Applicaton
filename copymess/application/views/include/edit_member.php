<?php
if (validation_errors()) {
    ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php } ?>

<?php echo form_open('dashboard/member/edit');
    foreach($rows as $row) {

?>
<input type="text" name="name" class="form-control" placeholder="Enter Your Name"
       value="<?php echo $row->name ?>">
<textarea name="address" class="form-control"
          placeholder="Enter Your Address"><?php echo $row->address ?></textarea>
<input type="text" name="mobile" class="form-control" placeholder="Enter Your Mobile Number"
       value="<?php echo $row->mobile ?>">
<input type="email" name="email" class="form-control" placeholder="Enter Your E-mail"
       value="<?php echo $row->email ?>">
<select name="occupation" class="form-control">
    <option value="0" selected="Select">Select</option>
    <?php
        if($row->occupation == 'Student') {
            echo '<option value="Student" selected = "Student">Student</option>';
            echo '<option value="Service">Service</option>';
        } else {
            echo '<option value="Student" selected = "Service">Service</option>';
            echo '<option value="Student">Student</option>';
        }
    ?>
</select>
        <input type="hidden" name="id" value="<?php echo $row->id;?>">
<input style="width: 300px" type="submit" class="btn btn-info" name="submit" value="Submit">

<?php
    }
?>