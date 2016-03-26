<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Total Meal | <span style="color:teal"><?php echo date('D M Y');?></span>
            </div>
            <div class="panel body">
                <table class="table table-condensed">
                    <tr><th>Name</th><th>Break Fast</th><th>Lunch</th><th>Dinner</th></tr>
                    <?php
                    $l = 0; $b = 0; $d = 0; $sum = 0; $x = 0;
                    foreach($rows as $row) {
                        //$total_meal = $row->breakfast_meal + $row->lunch_meal + $row->dinner_meal;
                        $b += $row->breakfast_meal;
                        $l += $row->lunch_meal;
                        $d += $row->dinner_meal;
                        if($x == 0) {
                            echo '<tr style="background-color:lightskyblue"><td>'.$row->name.'</td><td>'.$row->breakfast_meal.'</td>
                            <td>'.$row->lunch_meal.'</td><td>'.$row->dinner_meal.'</td></tr>';
                            $x = 1;
                        } else {
                            echo '<tr style="background-color:honeydew"><td>'.$row->name.'</td><td>'.$row->breakfast_meal.'</td>
                            <td>'.$row->lunch_meal.'</td><td>'.$row->dinner_meal.'</td></tr>';
                            $x = 0;
                        }
                    }
                    echo '<tr><td><b>Total</b></td><td><b>'.$b.'</b></td><td><b>'.$l.'</b></td><td><b>'.$d.'</b></td></tr>';
                    ?>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b>Note: </b>Meal can changer from meal panel
        </div>
    </div>
</div>
