<?php
session_start();
$uid_err = $pass_err = "";
//block access to login page when logged in
if (isset($_SESSION['username'])) {
	header("location: index.php");
	exit;
}
//Form Validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty(trim($_POST['uid']))) {
		$uid_err = "<span class=error> Username Required!</span>";
	} else {
		$uid = trim($_POST['uid']);
	}
	if (empty(trim($_POST['pass']))) {
		$pass_err = "<span class=error>猪 Password Required!</span>";
	} else {
		$pass =  MD5(trim($_POST['pass']));
	}
	//Done Validating
	if (empty($uid_err) && empty($pass_err)) {
		require_once('maria.php');

		$uid_check_query = "select * from employee_details where username = '$uid' && password = '$pass'";
		$check_uid = mysqli_query($db_connection, $uid_check_query);
		$match = mysqli_num_rows($check_uid);

		$email_check_query = "select * from employee_details where email = '$uid' && password = '$pass'";
		$email_uid = mysqli_query($db_connection, $email_check_query);
		$match_email = mysqli_num_rows($email_uid);

		if ($match > 0 || $match_email > 0) {
			session_start();
			$_SESSION["username"] = $uid;
			$_SESSION["status"] = true;
			header('location: index.php');
		} else {
			$uid_err = "<span class=error> Invalid Username or Password!</span>";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Login | Employee</title>
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
			} 
		   </style>
			   $uid_err
			   $pass_err ";
		echo $_SESSION["ac_creation_prompt"];
		if (!empty($_SESSION["ac_creation_prompt"])) {
			$_SESSION["ac_creation_prompt"] = "";
		}
		?>

		<h1>
			<\Login />
			</h2>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<input id="" class="username" name="uid" type="text" placeholder="Username/Email@xyz.com">
				<input id="" class="password" name="pass" type="password" placeholder="Password">
				<button class="login-btn" type="submit"><b> Login</b> </button>
				<h5>New Employee? <a href="register.php"> Register! </a> </h5>
			</form>
	</div>
</body>

</html>
