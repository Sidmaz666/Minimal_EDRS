<?php
session_start();
$uid =  $_SESSION["username"];
if(!isset($_SESSION['status']) || $_SESSION['status'] !==true)
{
	header("location: login.php");
	exit;
}

require_once('maria.php');
$select_ud = "select * from employee_details where username = '$uid' or  email ='$uid'" ;
$g_query = mysqli_query($db_connection,$select_ud);
$check_res = mysqli_num_rows($g_query);
if($check_res > 0){
	while ($info = mysqli_fetch_assoc($g_query)){
		$fullname = $info['fullname'];
		$department = $info['department'];
		$gender = $info['gender'];
		$username = $info['username']; 
		$email = $info['email']; 
		$creation_time = $info['creation_time'];
		$dob = $info['birthdate'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Attendence | Employee</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="https://www.pinclipart.com/picdir/big/344-3445944_png-file-svg-terminal-icon-png-clipart.png">
</head>
<body>
	<div class="main">
 <?php echo "<style type='text/css'>
		   .error {
				display:flex; align-content:center; 
				align-items:center; justify-content:center;
				flex-direction:column; position:inherit;	
				font-size:16px; border-bottom:1px solid  #155c59;
				padding-top:2px; padding-bottom:2px; 
				border-left:1px solid  #155c59;
				border-right:1px solid  #155c59;
				font-size:20px; line-height: 30px;
			}
			.udetails{
			color:#ffffff;
			}
			.arrow{
			color:#18c974;
			}
			.date{
			height:18px;
			width: 21%;
			padding:0.5%;
			margin: 1.7%;
			border: 2px solid #155c59;
			background:#23262b;
			color: #ffffff;
			cursor:pointer;
			}
			.date:hover , {
			border-bottom:2px solid #18c974;
			}
			::-webkit-calendar-picker-indicator {
 			   filter: invert(1);
			}
			::-webkit-datetime-edit {
 			   background-color:#23262b;
			}
		   </style>
			   $uid_err
			   $pass_err ";
			echo $_SESSION["ac_creation_prompt"];
			if (!empty($_SESSION["ac_creation_prompt"])){
				$_SESSION["ac_creation_prompt"] = "";
				}
?>

	<h1><\<?php echo "  ".$fullname ?>/> </h2>

	<?php echo "<span class=error><span class=udetails> Employee Name<span class=arrow> &#10150;</span> ".$fullname."</span></span><span class=error><span class=udetails>ﮮ Account Creation Date/Time<span class=arrow> &#10150;</span> ". $creation_time."</span></span><span class=error><span class=udetails>  Classified As<span class=arrow> &#10150;</span> " .$department ."</span></span><span class=error><span class=udetails>  Seen As<span class=arrow> &#10150;</span> ".$gender."</span></span><span class=error><span class=udetails> Alias/Username<span class=arrow> &#10150;</span> " .$username. "</span></span><span class=error><span class=udetails>  Email<span class=arrow> &#10150;</span> ".$email."</span></span><span class=error><span class=udetails>ﮮ DOB<span class=arrow> &#10150;</span> ".$dob."</span></span> " ;   ?> 



<?php

$checkin_record = "select * from employee_record where username = '$username'" ;
$c_query = mysqli_query($db_connection,$checkin_record);
$checkin_res = mysqli_num_rows($c_query);
if($checkin_res > 0){
	while ($details = mysqli_fetch_assoc($c_query)){
		$creation_time = $detalis['creation_time'];
		$checkin_time = $details['checkin_time'];
	}
}
			
$curr_date = date("Y-m-d");

if($_SERVER["REQUEST_METHOD"] == "POST"){
  if ($curr_date == $checkin_time){
    echo "<span class=error>✔ Already Checked In for today! </span>
<style>
.date , .hide {
display:none;
}
</style>
";
} else {
  $checkin_query = mysqli_query($db_connection,"INSERT INTO employee_record (fullname,email,username,checkin_time) VALUES ('$fullname','$email','$username','$curr_date')");
  echo  "<span class=error>✔ Checked-In! </span>
<style>
.date , .hide {
display:none;
}
</style>
";
}
}
				


?>
				<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
					<input class="date" placeholder="Date" type="date" name="date" min="<?php  echo $curr_date; ?>"
					 value="<?php  echo $curr_date; ?>" max="<?php  echo $curr_date; ?>"><br/>
					<button class="login-btn hide" type="submit" ><b> Check-in</b> </button>
				</form>


				<a href="logout.php"><input type="button" class="login-btn" value="Logout!"></a>	
	</div>
</body>

