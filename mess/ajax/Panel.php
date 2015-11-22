<?php
include_once 'Database.php';
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $obj = Database::getInstance()->get("system", array('mess_memberid', '=', $id));

    if(!$obj->count()) {
     echo '<h4>Meal has not saved, please save.</h4>';
    } else {
        echo '<span class="alert-success">Today '.date('d M Y').'</span><br/>';
        foreach($obj->result() as $row) {
            echo 'Breakfast Meal: '.$row->breakfast_meal.'<br/>';
            echo 'Lunch Meal: '.$row->lunch_meal.'<br/>';
            echo 'Dinner Meal: '.$row->dinner_meal.'<br/>';
        }
    }
}