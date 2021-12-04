<?php
include("maria.php");
$user_id = $_GET['id'];
$del_sql = "delete from employee_record where ID = '$user_id'";
$del_query = mysqli_query($db_connection, $del_sql);
if ($del_query) {
	header("location: record.php");
}
