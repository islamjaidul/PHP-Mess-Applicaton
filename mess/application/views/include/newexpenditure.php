<style>
    .fix{
        margin: 20px 0 20px 0;
    }
</style>
<?php
/**
 * Retrieve Total amount in Mess Accounts
 */
    $total = 0;
    $expense = 0;
    foreach($mess_accounts as $row) {
        $total += $row->amount;
    }

    foreach($expense_amount as $amount) {
        $expense += $amount->expense_amount;
    }

    $total = $total - $expense;
?>

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


<div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading">New Expenditure</div>
               <div class="panel-body">
                   <div class="col-md-5">
                       <?php
                       if($total > 0) {
                           echo form_open('dashboard/expenditure/new');
                           echo '<select name="mess_memberid" class="form-control">';
                           echo '<option value="0" selected="Select">Select Member</option>';

                           foreach ($rows as $row) {
                               echo '<option value="' . $row->id . '">' . $row->name . '</option>';
                           }
                           echo '</select>';
                           ?>
                           <input type="number" name="expense_amount" class="form-control" placeholder="Enter the Amount" value="<?php echo set_value('expense_amount');?>">
                           <textarea name="shopping" placeholder="Enter the Shopping Description" class="form-control"></textarea>
                           <input style="width:300px" type="submit" class="btn btn-info" value="Submit" name="Submit">

                           <?php
                           //End Condition
                       } else if($total == 0) {
                           echo '<div class="fix"><span class="alert alert-danger"><b>There are no sufficient money to do expense.</b></span></div>';
                       }
                       ?>
                   </div>

                   <div class="fix col-md-7">
                       <?php
                       if($total <= 500) {
                           echo '<span class="alert alert-danger"><b>Mess Accounts Remaining '.$total.' TK. Please refund</b></span>';
                       }else if($total > 500) {
                           echo '<span class="alert alert-success"><b>Mess Accounts Remaining '.$total.' TK.</b></span>';
                       }
                       ?>
                   </div>
               </div>

        </div>
</div>

