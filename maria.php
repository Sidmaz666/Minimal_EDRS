<?php
$servername = "localhost";
    $dbusername = "root";
    $dbpassword = "root";
    $dbname = "employee";
    $connection = new mysqli($servername, $dbusername, $dbpassword);
    if ($connection->connect_error) {
      die("Server Not Responding!.." . $connection->connect_error);
    }
$dbcreate = "CREATE DATABASE IF NOT EXISTS ".$dbname;
if ($connection->query($dbcreate) === TRUE) {
  $db_connection = new mysqli($servername, $dbusername, $dbpassword, $dbname);
  if ($db_connection->connect_error) {
    die("Unable to create the Database " . $db_connection->connect_error);
  }
  $tablecreate = "CREATE TABLE IF NOT EXISTS employee_details (ID int(11) AUTO_INCREMENT,
		      fullname varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			username varchar(255) NOT NULL,
                      password varchar(255) NOT NULL,
			department varchar(255) NOT NULL,
			birthdate date NOT NULL,
			gender varchar(255) NOT NULL,
			creation_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,	
                      PRIMARY KEY  (ID))";
  if($db_connection->query($tablecreate) === TRUE) {
    
  }else{
    echo "Database & Tables Created" . $db_connection->error;
  }
  $erecordtable="CREATE TABLE IF NOT EXISTS employee_record (ID int(11) AUTO_INCREMENT,
		      fullname varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			username varchar(255) NOT NULL,
			checkin_time date NOT NULL,
			creation_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,	
		      PRIMARY KEY  (ID))";
  if($db_connection->query($erecordtable) === TRUE) {
    
  }else{
    echo "Employee Record Database & Tables Created" . $db_connection->error;
  }


} else {
  echo "Error creating database: " . $connection->error;
}
 
