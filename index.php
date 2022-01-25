<?php
session_start();
$uid =  $_SESSION["username"];
if (!isset($_SESSION['status']) || $_SESSION['status'] !== true) {
	header("location: login.php");
	exit;
}

require_once('maria.php');

$select_ud = "select * from employee_details where username = '$uid' or  email ='$uid'";
$g_query = mysqli_query($db_connection, $select_ud);
$check_res = mysqli_num_rows($g_query);
if ($check_res > 0) {
	while ($info = mysqli_fetch_assoc($g_query)) {
		$fullname = $info['fullname'];
		$department = $info['department'];
		$gender = $info['gender'];
		$username = $info['username'];
		$email = $info['email'];
		$creation_time = $info['creation_time'];
		$dob = $info['birthdate'];
	}}

$fetch_emp_pvd = "select * from employee_private_details where username = '$username'";
$fetch_query = mysqli_query($db_connection, $fetch_emp_pvd);
$check_existance = mysqli_num_rows($fetch_query);
if ($check_existance > 0) {
	while ($pvd = mysqli_fetch_assoc($fetch_query)) {
		$p_fullname = $pvd['fullname'];
		$p_email = $pvd['email'];
		$p_username = $pvd['username'];
		$phoneno = $pvd['phone'];
		$locatioa = $pvd['location'];
		$creation_times = $pvd['creation_time'];
		$descriptions = $pvd['description'];
		$ido= $pvd['ID'];
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
			    ";

		?>

		<h1>
			<\<?php echo "  " . $fullname ?> />
			</h2>
			<?php echo "<span class=error><span class=udetails> Employee Name<span class=arrow> &#10150;</span> " . $fullname . "</span></span><span class=error><span class=udetails>ﮮ Account Creation Date/Time<span class=arrow> &#10150;</span> " . $creation_time . "</span></span><span class=error><span class=udetails>  Classified As<span class=arrow> &#10150;</span> " . $department . "</span></span><span class=error><span class=udetails>  Seen As<span class=arrow> &#10150;</span> " . $gender . "</span></span><span class=error><span class=udetails> Alias/Username<span class=arrow> &#10150;</span> " . $username . "</span></span><span class=error><span class=udetails>  Email<span class=arrow> &#10150;</span> " . $email . "</span></span><span class=error><span class=udetails>ﮮ DOB<span class=arrow> &#10150;</span> " . $dob . "</span></span> ";   ?>

<?php
		if ($ido > 0){
		echo "<h2><b>More Details of $p_fullname / Profile Update History<b></h2>";
		echo "<span class=error><span class=udetails> Phone Number<span class=arrow> &#10150;</span>".$phoneno."</span></span>";
		echo "<span class=error><span class=udetails> Location/Address<span class=arrow> &#10150;</span>".$locatioa."</span></span>";
		echo "<span class=error><span class=udetails> About/Bio<span class=arrow> &#10150;</span>".$descriptions."</span></span>";
		echo "<span class=error><span class=udetails> ⏱  Updated On <span class=arrow> &#10150;</span>".$creation_times."</span></span>";
		}


			$checkin_record = "select * from employee_record where username = '$username'";
			$c_query = mysqli_query($db_connection, $checkin_record);
			$checkin_res = mysqli_num_rows($c_query);
			if ($checkin_res > 0) {
				while ($details = mysqli_fetch_assoc($c_query)) {
					$creation_time = $detalis['creation_time'];
					$checkin_time = $details['checkin_time'];
				}
			}

			$curr_date = date("Y-m-d");

			
				if(isset($_POST['checkinbtn']))
				{
				if ($curr_date == $checkin_time) {
					echo "<span class=error>✔ Already Checked In for today! </span>
						<style>
						.date , .hide {
						display:none;
						}
						</style>";
				} else {
					$checkin_query = mysqli_query($db_connection, "INSERT INTO employee_record (fullname,email,username,checkin_time) VALUES ('$fullname','$email','$username','$curr_date')");
					echo  "<span class=error>✔ Checked-In! </span>
						<style>
						.date , .hide {
						display:none;
						}
						</style>";
				}}


if(isset($_POST["updatepro"])){

  		$g_phone=$_POST['phone'];
  		$g_location=$_POST['location'];
  		$g_description=$_POST['description'];

		$update_profile = "INSERT INTO `employee_private_details` (fullname,email,username,phone,location,description) VALUES ('$fullname','$email','$username','$g_phone','$g_location','$g_description')";
		$upyou = mysqli_query($db_connection,$update_profile);
		if($upyou){
		  echo "<span class=error> $username Profile Updated! Redirecting...</span>";
		 header("refresh:5; url=index.php");
	} else {
		$updateprofile = "INSERT INTO `employee_private_details` (fullname,email,username,phone,location,description) VALUES ('$fullname','$email','$username','$g_phone','$g_location','$g_description')";
		$upyouu = mysqli_query($db_connection,$updateprofile);
		if($upyouu){
		  echo "<span class=error> $username Profile Updated! Redirecting...</span>";
		 header("refresh:5; url=index.php");
	} else {
	
		$updateprofile = mysqli_query($db_connection,"INSERT INTO `employee_private_details` (fullname,email,username,phone,location,description) VALUES ('$fullname','$email','$username','$g_phone','$g_location','$g_description')");
		if($updateprofile){
		  echo "<span class=error> $username Profile Updated! Redirecting...</span>";
		 header("refresh:5; url=index.php");
	} else {

		$updateprofile = mysqli_query($db_connection,"INSERT INTO `employee_private_details` (fullname,email,username,phone,location,description) VALUES ('$fullname','$email','$username','$g_phone','$g_location','$g_description')");
		if($updateprofile){
		  echo "<span class=error> $username Profile Updated! Redirecting...</span>";
		 header("refresh:5; url=index.php");
		}
		  echo "<span class=error> Unable to Update Try Again!</span>";

	}

	}


	}
}


			if(isset($_POST['deleteinfo'])){
			$deleteinformation = "DELETE FROM employee_private_details WHERE ID = '$ido'";
			$delcon = mysqli_query($db_connection,$deleteinformation);
			if($delcon){
		  echo "<span class=error> $username Profile Info Deleted! Redirecting...</span>";
		 header("refresh:5; url=index.php");
			}
			}


?>

			<form action="" method="post">
				<input class="date" placeholder="Date" type="date" name="date" min="<?php echo $curr_date; ?>" value="<?php echo $curr_date; ?>" max="<?php echo $curr_date; ?>"><br />
				<button class="login-btn hide" name="checkinbtn" type="submit"><b> Check-In</b> </button>
			</form>
			<?php if ($username == "admin") { ?>
				<a href="record.php"><input type="button" style="font-weight:bold" class="login-btn" value="View Employee Records"></a>
			<?php } ?>


			<?php if ( $ido > 0) { ?>
			<form action="" method="post">
			<button style="font-weight:bold" name="deleteinfo" class="login-btn"> Delete_&_Update_Profile!</button>
			</form>
			<style>
			.headache{
			display:none;
			}
			</style>
			<?php } ?> 			

			<div class="headache">
				
			<script type="text/javascript">
			function show(){
			const info = document.querySelector(".info");
			const minfo = document.querySelector("#moreinfo");
			info.style.display = "inline-block";
			minfo.style.display = "none";
			document.querySelector('#moreinfo2').style.display = "inline-block"
			}
			function hide(){
			const info = document.querySelector(".info");
			const minfo = document.querySelector("#moreinfo");
			info.style.display = "none";
			minfo.style.display = "inline-block";
			document.querySelector('#moreinfo2').style.display = "none"
			}
			
			</script>

			<input type="button" class="login-btn" id="moreinfo" value="Complete/Edit Profile!" onclick="show()">
			<input type="button" style="display:none" class="login-btn" id="moreinfo2" value="Complete/Edit Profile!" onclick="hide()">

			<div class="info" style="display:none">

			<form action="" method="post">
			<input type="number" class="login-btn" name="phone" placeholder="Enter Phone Number!" required>
			<input type="text" class="login-btn" name="location" placeholder="Enter Location" required>
			<input type="text" class="login-btn" name="description" placeholder="Add Description" required>
			<br>
			<button name="updatepro" style="width:80px" class="login-btn">Submit!</button>
			</form>

			</div>
			</div>
			<a href="logout.php"><input type="button" class="login-btn" value="Logout!"></a>
	</div>
</body>
