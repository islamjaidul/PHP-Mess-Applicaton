<?php
if (validation_errors()) {
    ?>
    <div class="alert alert-danger">
        <?php echo validation_errors(); ?>
    </div>
<?php } ?>


<?php
    echo form_open('dashboard/meal/edit');
    foreach($rows as $row) {
?>
<select name="member" id="member" class="form-control">
       <option value="<?php echo $row->member_id;?>" selected="<?php echo $row->name;?>"><?php echo $row->name;?></option>
</select>
<input type="text" class="form-control" name="breakfast_meal" id="breakfast_meal" value="<?php echo $row->breakfast_meal;?>" placeholder="Enter your Breakfast Meal">
<input type="text" class="form-control" name="lunch_meal" id="lunch_meal" value="<?php echo $row->lunch_meal;?>" placeholder="Enter your Lunch Meal">
<input type="text" class="form-control" name="dinner_meal" id="dinner_meal" value="<?php echo $row->dinner_meal;?>" placeholder="Enter your Dinner Meal">
<input type="hidden" name="id" value="<?php echo $row->id;?>">
<input style="width:300px" type="submit" class="btn btn-info" value="Save">
</form>

<?php }?>

