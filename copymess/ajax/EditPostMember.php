<?php
$con = mysqli_connect("localhost","root","","mess");

// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if($con) {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $occupation = $_POST['occupation'];
        $sql = 'UPDATE mess_member SET name = '.$name.' WHERE id ='.$id;

        if(mysqli_query($con, $sql)) {
            echo 'successfully updated';
        } else {
            die(mysqli_error($con));
        }


    }
}