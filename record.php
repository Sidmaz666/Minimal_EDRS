<?php
session_start();
if(!isset($_SESSION['status']) || $_SESSION['status'] !==true)
{
	header("location: login.php");
	exit;
}
if ($_SESSION['username'] !== "admin"){
  header('location: index.php');
  exit;
}
echo "
<title> Employee Records </title>
<link rel='stylesheet' href='style.css'>
	<link rel='shortcut icon' href='https://www.pinclipart.com/picdir/big/344-3445944_png-file-svg-terminal-icon-png-clipart.png'>
<br/><center><h1> Employee Records</h1></center>
<style type='text/css'>
			body{
				height:98.4%;
				overflow:auto;
			}
			.main{
				text-align:left;
			}
		   .error {
				font-size:20px; border-bottom:2px solid  #18c974;
				margin-bottom:5%; 
			}
			.pu{
			color:#b855fa;
			}
				b , i{
					padding:0.9%;
				}
			.ge{color:#1ac79c;}
			i{color:#b5d904}
				.con{color:#d408c9}
			table, th, td {
			  border:2px solid #155c59;
				padding:5px;
			}	
		   </style>
<div class=main style='border:0; max-width:100%; margin-top: 1%'>
<table style='width:100%;font-size:20px'>
<tr>
<th><b class=pu><big></big> </b>User<i><big> ▼</big></i> </th>
<th><b class=ge><big>ﮮ</big></b> Present On<i><big> ▼</big></i> </th>
<th> <i class=con><big> </big></i>  Contact<i><big> ▼</big></i> </th>
</tr>
";
require_once('maria.php');
$select_record = "select * from employee_record" ;
$r_query = mysqli_query($db_connection,$select_record);
$check_rec = mysqli_num_rows($r_query);
if($check_rec > 0){
	while ($erecord = mysqli_fetch_assoc($r_query)){
		$fullname = $erecord['fullname'];
		$email = $erecord['email'];
		$check_time = $erecord['checkin_time'];
	echo	"<tr>
		  <td><b class=pu> $fullname</b></td>
		  <td>  <b class=ge> $check_time</b> </td>
		  <td> <i class=con> $email</i><span>  </td>
			 </tr>";


	}
}
echo "</div>";
?>

