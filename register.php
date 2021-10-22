<?php
session_start();
//block access  to register page if logged in

if(isset($_SESSION['username']))
{
    header("location: index.php");
    exit;
}
require_once('maria.php');
// User Inputs VAR...
$username = $fullname = $email = $gender = $department = $password = $cpassword = "";
$username_err = $password_err = $email_err = $cpassword_err = $fullname_err = "";

//On POST REQ
// Form Validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["username"]))) {
    $username_err = "<span class=error> Username is required</span>";
  } else {
    $username = trim($_POST["username"]);
  }
  if (empty(trim($_POST["email"]))) {
    $email_err = "<span class=error> Email is required</span>";
  } else {
    $email = trim($_POST["email"]);
  }
  if (empty(trim($_POST["fullname"]))) {
    $fullname_err = "<span class=error> Full Name is Required</span>";
  } else {
    $fullname = trim($_POST["fullname"]);
  }
  if (empty(trim($_POST["birthdate"]))) {
    $birthdate_err = "<span class=error> Birth-Date is Required</span>";
  } else {
    $birthdate = trim($_POST["birthdate"]);
  }
  if(empty(trim($_POST['password']))){
	  $password_err ="<span class=error> Pasword Cannot be Empty!</span>";
  }
  elseif (trim($_POST["password"]) != trim($_POST['cpassword'])) {
    $cpassword_err = $password_err = "<span class=error>漏 Re-Enter Correct Password</span>";
  }
  elseif(strlen(trim($_POST["password"])) < 5){
	  $password_err = "<span class=error>猪 Enter a Strong Password</span>";
  }
  else {
    $password = trim($_POST["cpassword"]);
  }
  // The Default Gender is Other
  if (empty(trim($_POST["gender"]))) {
    $gender = "other";
  } else {
    $gender = trim($_POST["gender"]);
  }

$check_email = mysqli_query($db_connection, "SELECT email FROM employee_details where email = '$email' ");
if(mysqli_num_rows($check_email) > 0){
    $email_err="<span class=error> $email is Already Registered!</span>";
}

$check_username = mysqli_query($db_connection, "SELECT username FROM employee_details where username = '$username' ");
if(mysqli_num_rows($check_username) > 0){
    $username_err="<span class=error> Username '$username' is Taken!</span>";
}
//Done Validating
//Default Encryption for Password
$secure_password = MD5($password);
// Post Data To the Database judi sob thik ache
if(empty($username_err) && empty($email_err) && empty($fullname_err) && empty($password_err) && empty($cpassword_err) && empty($birthdate_err))
{
	if(empty(trim($_POST['department']))){
		$department = "human";
	} else {
		$department = trim($_POST["department"]);
	}
		$query_user_register = "INSERT INTO employee_details (fullname,email,username,password,department,birthdate,gender) VALUES ('$fullname','$email','$username','$secure_password','$department','$birthdate','$gender')";
		$regyou = mysqli_query($db_connection,$query_user_register);
		if($regyou){
		session_start();
                $_SESSION["ac_creation_prompt"] = "<span class=error> $username, Account Has been Created!</span>";	
		header('location: login.php');
	} else {
		  $password_err ="<span class=error> Unable to Create Account!</span>";

	}}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Register | New Employee</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<link rel="shortcut icon" href="https://www.pinclipart.com/picdir/big/344-3445944_png-file-svg-terminal-icon-png-clipart.png">
	
</head>
<body>
	<div class="main" style="margin-top:2.5%; padding-top:1%">

		    <?php echo "<style type='text/css'>
		   .error {
				display:flex; align-content:center; 
				align-items:center; justify-content:center;
				flex-direction:column; position:inherit;	
				font-size:16px; border-bottom:1px solid  #155c59;
				padding-top:2px; padding-bottom:2px; 
				border-left:1px solid  #155c59;
				border-right:1px solid  #155c59;
			} 
		   </style>
		     $fullname_err
		    $email_err 
		    $username_err 
		    $password_err
		    $birthdate_err
			"; 
 ?>
		<h1><\Register/> </h2>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<input id="fullname" class="username" name="fullname" type="text" placeholder="Full Name" >
		<input id="email" class="email" name="email" type="text" placeholder="Email@xyz.abc">
		<input id="username" class="username" name="username" type="text" placeholder="Username">
		<input id="password" class="password" name="password"  type="password"  placeholder="Password" >
		<input id="cpassword" class="cpassword" name="cpassword"  type="password" placeholder="Confirm Password">
	
<br/>
<label><b><i>Choose Your Department</i></b></label>
<select class="department" name="department">
		<option value="god">God</option>
		<option value="angel">Angel</option>
		<option value="human" selected>Human</option>
		<option value="politician">Politician</option>
		<option value="lawyer">Lawyer</option>
		<option value="loli"> Loli </option>
		<option value="loli">Programmer </option>
		<option value="devil">Student</option>
		<option value="Noone">Ignorance</option>
		<option value="devil">Slave</option>
		<option value="Noone">No-One</option>
	</select>
<br/>
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
		   </style>";
				$curr_date = date("Y-m-d");		 
?>

			<span><b><i>Date Of Birth</i></b></span>
			<input class="date" type="date" name="birthdate" max="<?php echo $curr_date;  ?>" >
<br/>
		<div class="annoying_checkbox">
		<span><i><b>Gender</b></i></span>
				<label  class="gender">
			<input type="checkbox" id="" class="" name="gender" value="male">
			<span>Male</span>
			</label>
			<label  class="gender">
			<input type="checkbox" id="" class="" name="gender" value="female">
			<span>Female</span>
			</label>
			<label  class="gender">
			<input type="checkbox" id="" class="" name="gender" value="other">
			<span>Other</span>
			</label>
		</div>
				<button class="regbtn" type="submit"><b> Register</b> </button>
				<h5>Already Registered? <a href="login.php"> Login! </a> </h5>
			</form>
		</div>
	</body>
</html>
