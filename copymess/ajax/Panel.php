<?php
include_once 'Database.php';
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $obj = Database::getInstance()->get("system", array('mess_memberid', '=', $id));

    if(!$obj->count()) {
     echo '<h4>Meal has not saved, please save.</h4>';
    } else {
        foreach($obj->result() as $row) {
            if($row->updated_at != null) {
                echo '<span class="alert-info">Last Modified '.$row->updated_at.'</span><br/>';
            } else {
                echo '<span class="alert-info">Last Modified '.$row->created_at.'</span><br/>';
            }
            break;
        }
        echo '<span class="alert-success">Today '.date('d M Y').'</span><br/>';
        foreach($obj->result() as $row) {
            echo 'Breakfast Meal: '.$row->breakfast_meal.'<br/>';
            echo 'Lunch Meal: '.$row->lunch_meal.'<br/>';
            echo 'Dinner Meal: '.$row->dinner_meal.'<br/>';
        }
    }
}