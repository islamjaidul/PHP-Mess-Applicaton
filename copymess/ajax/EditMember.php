<?php
include_once 'Database.php';
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $rows = Database::getInstance()->query("select * from mess_member where id = ($id);");
    foreach($rows->result() as $row) {
        echo '<input style="border-radius:5px" class="form-control" type="text" name="name" id="name" value="'.$row->name.'">';
        echo '<textarea style="border-radius:5px" name="address" id="address" class="form-control" placeholder="Enter Your Address">'.$row->address.'</textarea>';
        echo '<input style="border-radius:5px" class="form-control" type="text" name="mobile" id="mobile" value="'.$row->mobile.'">';
        echo '<input style="border-radius:5px" type="email" name="email" id="email" class="form-control" placeholder="Enter Your E-mail"
       value="'.$row->email.'">';
        echo '<select style="border-radius:5px" class="form-control" name = "occupation" id="occupation">';
                if($row->occupation == 'Student') {
                    echo '<option value="Student" selected="Student">Student</option>';
                    echo '<option value="Service">Service</option>';
                } else {
                    echo '<option value="Service" selected = "Service">Service</option>';
                    echo '<option value="Student">Student</option>';
                }
        echo '</select>';
        echo '<input type="hidden"  name="id" id = "update_id" value="'.$id.'">';
    }
}


?>

