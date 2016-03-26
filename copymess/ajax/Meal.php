<?php
include_once 'Database.php';
date_default_timezone_set('Asia/Dhaka');
if(isset($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 20;
}

if(isset($_POST['id'])) {
    $id = $_POST['id'];
}

$rows = Database::getInstance()->query('select ml.*, mm.name from mess_meal as ml, mess_member as mm WHERE ml.mess_memberid = mm.id and ml.usersid = '.$id.' and ml.month = '.(int)date('m').' order by ml.id desc limit '.$limit.';');
?>
<table class="table table-bordered">
    <tr>
        <th>Name</th><th>Breakfast</th><th>Lunch</th><th>Dinner</th><th>Date</th><th>Action</th>
    </tr>
    <?php
    foreach($rows->result() as $row) {
    ?>
        <tr>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->breakfast_meal;?></td>
            <td><?php echo $row->lunch_meal;?></td>
            <td><?php echo $row->dinner_meal;?></td>
            <td><?php echo $row->created_at;?></td>
            <td> <a href="<?php echo 'meal/edit/'.$row->id.'';?>" id="<?php echo $row->id?>" class="label label-info"><i class="fa fa-pencil-square-o"></i></a></td>
        </tr>

    <?php }?>
</table>
