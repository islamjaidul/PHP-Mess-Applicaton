<div class="row">
    <div class="col-md-3">
        <?php
        $total_member = 0;
        foreach($member as $row) {
            ++$total_member;
        }
        ?>
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Members</span>
                <span class="info-box-number"><?php echo $total_member;?></span>
            </div><!-- /.info-box-content -->
        </div>
    </div>

    <div class="col-md-3">
        <?php
        $total_accounts = 0;
        foreach($accounts as $row) {
            $total_accounts += $row->amount;
        }
        ?>
        <div class="info-box">
            <span class="info-box-icon bg-red"><i c<i class="ion-cash"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Accounts</span>
                <span class="info-box-number"><?php echo $total_accounts;?></span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $total_expense = 0;
        foreach($expenditure as $row) {
            $total_expense += $row->expense_amount;
        }
        ?>
        <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Expense</span>
                <span class="info-box-number"><?php echo $total_expense;?></span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
    <div class="col-md-3">
        <?php
        $total_meal = 0;
        foreach($meal as $row) {
            $total_meal += $row->breakfast_meal + $row->lunch_meal + $row->dinner_meal;
        }
        ?>
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion-fork"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Meal</span>
                <span class="info-box-number"><?php echo $total_meal;?></span>
            </div><!-- /.info-box-content -->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Meal Rate</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <?php
                if($total_expense != 0 && $total_meal != 0) {
                    echo '<h2 style="color:red">Current Meal Rate </h2>'.'<h3 style="color:red">TK '.number_format((float)$total_expense / $total_meal, 2, '.', '').'</h3>';
                } else {
                    echo '<h3 style="color:red">Meal Rate Not Available</h3>';
                }
                ?>
            </div><!-- /.box-body -->

        </div>
    </div>
    <div class="col-md-4">
    </div>
    <div class="col-md-4"></div>
</div>
