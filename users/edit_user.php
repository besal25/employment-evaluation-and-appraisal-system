<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM users where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
include 'users/new_user.php';
?>