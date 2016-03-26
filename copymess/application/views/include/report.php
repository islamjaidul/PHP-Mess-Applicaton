<div class="box box-info">
    <div class="box-header">
        <span><a class="label label-success" style="color:#ffffff; text-decoration:none" href="<?php echo base_url('dashboard/archive/report')?>"><i class="fa fa-archive"></i>  Archive</a></span>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Meal Report
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <?php
                            $b = 0;
                            $l = 0;
                            $d = 0;
                            $name = null;
                            $total_meal = 0;
                            $sum = 0;
                            $rate = 0;
                            if(count($member) != 0) {
                                echo '<tr><th>Name</th><th>Total Meal</th></tr>';
                                for($i = 0; $i < count($member); $i++) {
                                    foreach($member[$i] as $row) {
                                        $name = $row->name;
                                        $b += $row->breakfast_meal;
                                        $l += $row->lunch_meal;
                                        $d += $row->dinner_meal;
                                    }
                                    if($name != null) {
                                        $sum = $b + $l + $d;
                                        echo '<tr><td>'.$name.'</td><td>'.$sum.'</td></tr>';
                                    }
                                    $total_meal += $sum;
                                    $b = 0;
                                    $l = 0;
                                    $d = 0;
                                    $name = null;
                                }
                            } else {
                                echo '<h4 style="color:red; text-align: center;">Meal Report is Not Available</h4>';
                            }
                            ?>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Meal & Expenditure
                    </div>
                    <div class="panel-body">
                        <span style="color:teal; display: block">Date <?php echo date('d-m-Y');?></span>
                        <?php echo 'Total Meal: '.$total_meal;?>
                        <?php
                        $total_expense = 0;
                        foreach($expenditure as $row) {
                            $total_expense += $row->expense_amount;
                        }
                        echo '<br/>Total Expenditure: '.$total_expense.' TK';
                        ?>
                        <h4 style="color: red;">Meal Rate: <?php
                            if($total_meal != 0 && $total_expense != 0) {
                                $rate = number_format((float)$total_expense / $total_meal, 2, '.', '');
                                echo $rate.' TK';
                            } else {
                                echo 'Not Available';
                            }
                            ?></h4>
                    </div>
                </div>
            </div>




            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Transaction Report
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped">
                            <?php
                            $b = 0;
                            $l = 0;
                            $d = 0;
                            $name = null;
                            $total_meal = 0;
                            $sum = 0; $arr = 0;
                            foreach($accounts as $row) {
                                foreach($row as $row) {
                                    $sum += $row->amount;
                                }
                                $accounts[$arr] = $sum;
                                $arr++;
                                $sum = 0;
                            }
                            if(count($member) != 0 && count($accounts) != 0) {
                                echo '<tr><th>Name</th><th>Accounts</th><th>Total</th><th>Will Take</th><th>Will Give</th></tr>';
                                //Retrieve data across of Member with all information.
                                for($i = 0; $i < count($member); $i++) {
                                    foreach($member[$i] as $row) {
                                        $name = $row->name;
                                        $b += $row->breakfast_meal;
                                        $l += $row->lunch_meal;
                                        $d += $row->dinner_meal;
                                    }
                                    if($name != null) {
                                        $sum = $b + $l + $d;
                                        echo '<tr><td>'.$name.'</td>';
                                        if($accounts[$i] == 0) {
                                            echo '<td>0</td>';
                                        } else {
                                            echo '<td>'.number_format((float)$accounts[$i], 2, '.', '').'</td>';
                                        }
                                        $sum = $sum * $rate;
                                        echo'<td>'.number_format((float)$sum, 2, '.', '').'</td>';

                                        $give = $accounts[$i] - $sum;
                                        $take = $sum - $accounts[$i];

                                        if($give > $take) {
                                            echo '<td style="color:green">'.$give.'</td>';
                                        } else {
                                            echo '<td>---</td>';
                                        }

                                        if($give < $take) {
                                            echo '<td style="color:red">'.$take.'</td>';
                                        } else {
                                            echo '<td>---</td>';
                                        }

                                        echo '<tr/>';
                                    }
                                    $total_meal += $sum;
                                    $b = 0;
                                    $l = 0;
                                    $d = 0;
                                    $name = null;
                                }
                            } else {
                                echo '<h4 style="color:red; text-align: center;">Transaction Report is Not Available</h4>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
