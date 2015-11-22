<?php
include_once 'Database.php';
if(isset($_POST['limit'])) {
    $limit = $_POST['limit'];
} else {
    $limit = 20;
}

if(isset($_POST['id'])) {
    $id = $_POST['id'];
}



$rows = Database::getInstance()->query('select ml.*, mm.name from mess_meal as ml, mess_member as mm WHERE ml.mess_memberid = mm.id and ml.usersid = '.$id.' order by id desc limit '.$limit.';');
?>
<table class="table table-striped">
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
            <td>Edit | Delete</td>
        </tr>

    <?php }?>
</table>
