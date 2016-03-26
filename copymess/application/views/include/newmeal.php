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


<input type="number" value="45" class="form-control">
