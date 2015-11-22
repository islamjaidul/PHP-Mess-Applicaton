<?php
include_once 'Database.php';
/**
 *Json Data Details / From View
 *
 * @id comes from meal.php
 * @limit comes from meal.php
 * @table comes from meal.php
 */

if(isset($_POST['id']) && isset($_POST['limit']) && isset($_POST['table'])) {
    $id = $_POST['id'];
    $limit = $_POST['limit'];
    $table = $_POST['table'];

    $obj = Database::getInstance()->query('select * from '.$table.' WHERE usersid = '.$id.';');    //This is pagination page number
    $total = $obj->count() / $limit;
    if(is_float($total)) {
        $total = intval($total)+1;
    }

    for($i = 1; $i <= $total; $i++) {
        echo '<option value="'.$i.'">'.$i.'</option>';
    }
}

/**
 *Json Data Details / From View
 * @pageid comes from meal.php
 * @limit comes form meal.php
 * @usersid comes from meal.php
 */

if(isset($_POST['pageid']) && $_POST['limit'] && $_POST['id']) {
    $pageid = $_POST['pageid'];
    $limit = $_POST['limit'];
    $id = $_POST['id'];
    $to = $limit * $pageid;
    $from = $to - $limit;

    $rows = Database::getInstance()->query('select ml.*, mm.name from mess_meal as ml, mess_member as mm WHERE ml.mess_memberid = mm.id and ml.usersid = '.$id.' order by id desc limit '.$from.', '.$limit.';');
}
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

