<table class="table table-striped">
    <tr>
        <th>Name</th><th>Breakfast</th><th>Lunch</th><th>Dinner</th><th>Date</th>
    </tr>
    <?php
    foreach($rows as $row) {
        ?>
        <tr>
            <td><?php echo $row->name;?></td>
            <td><?php echo $row->breakfast_meal;?></td>
            <td><?php echo $row->lunch_meal;?></td>
            <td><?php echo $row->dinner_meal;?></td>
            <td><?php echo $row->created_at;?></td>
        </tr>

    <?php }?>
</table>