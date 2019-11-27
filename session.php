<?php
// Establishing Connection with Server by passing server_name, user_id and password as a parameter
include("dbconfig.php");
session_start(); // Starting Session
// Storing Session
$user_check = $_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
	$ses_sql = mysqli_query($conn,"SELECT user_Fullname,user_Name,user_Img,user_ID,user_Email,lvl_ID FROM `user` WHERE user_Name='$user_check'");
	$row = mysqli_fetch_assoc($ses_sql);
	$login_session = $row['user_Name'];

	$_SESSION['login_level'] = $row['lvl_ID'];
	$_SESSION['login_id'] = $row['user_ID'];
	$_SESSION['user_Name'] = $row['user_Name'];

	if (!empty($row['user_Img'])) {
	 $_SESSION['user_Img']= 'data:image/jpeg;base64,'.base64_encode($row['user_Img']);
	}
	else{
	  $_SESSION['user_Img'] = "../assets/img/uploads/blank.png";
	}

	$_SESSION['user_Fullname'] = $row['user_Fullname'];
	$_SESSION['user_Email'] = $row['user_Email'];


if (!isset($login_session))
{
  mysqli_close($conn); // Closing Connection
  header('Location: ../index.php'); // Redirecting To Home Page
}

?>