<?php
include_once 'Database.php';
//Receiving the json data from js/Controller.js
//Created by Angular js.
$data = json_decode(file_get_contents("php://input"));
$id = $data->id;
$usersid = $data->usersid;
$month = $data->month;
$db = Database::getInstance();
$sql = $db->delete('expenditure', array('id', '=', $id));

if($sql) {
    $sql = $db->query('select m.name, e.* from expenditure as e, mess_member as m where e.mess_memberid = m.id and e.month = '.$month.' and e.usersid = '.$usersid.';');
    $sql = $db->result($sql);
    echo json_encode($sql);
}