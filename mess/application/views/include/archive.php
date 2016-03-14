<?php
$error = count($month);
if($error > 1) {
    for($i = 0; $i < (count($month)-1); $i++) {
        ?>

        <div>
            <ul>
                <li>
                    <a href="<?php echo base_url('dashboard/archive/meal/month/'.$month_number[$i].'');?>"><?php echo $month[$i];?></a>
                    <br/>
                </li>
            </ul>
        </div>
        <?php
    }
} else {
    echo '<h4 style="color:red; text-align: left;">Sorry, No Archiving</h4>';
}
?>