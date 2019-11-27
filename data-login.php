<?php
/**
 * @package    
 *
 * @copyright  Copyright (C) 2019, All rights reserved.
 * @license    MIT License version or later; see licensing/LICENSE.txt
 */

session_start(); // Starting Session

include('data-md5.php');
// $error=''; // Variable To Store Error Message

if (isset($_POST['operation'])) {
	if ($_POST['operation'] == "submit_login") {
		if (empty($_POST['username']) || empty($_POST['password'])) 
			{
				echo "<script>
				alertify.alert('Username or Password is empty !').setHeader('Error');
										window.location='index.php';
									</script>";

			
			}
		else
		{
			
			login();
			
		}
	}
		
}

function login(){

			include('dbconfig.php');
			// Define $username and $password
			$output = array();
			$username=$_POST['username'];
			$password=$_POST['password'];
			// To protect MySQL injection for Security purpose
			$username = stripslashes($username);
			$password = stripslashes($password);
			$username = mysqli_real_escape_string($conn,$username);
			$password = mysqli_real_escape_string($conn,$password);
			
			
 			$input = "$password";
			$encrypted = encryptIt($input);
			// SQL query to fetch information of registerd users and finds user match.
			$query = mysqli_query($conn,"SELECT * FROM `user` WHERE `user_Name` = '$username' AND `user_Pass` = '$encrypted' ");
			if (mysqli_num_rows($query) > 0) 
			{
				$rows = mysqli_fetch_assoc($query);
				// And error has occured while executing
			    if ($rows['lvl_ID']) 
				{

					$_SESSION['login_user']=$username; // Initializing Session
						// header("location: dashboard/"); //go to dashboard
					$output["success"] = "Successfully Login";


				} 

			}
			else
			{
			 		$output["error"] = "Wrong Username or Password!";
			}
			echo json_encode($output,true);
			mysqli_close($conn); // Closing Connection

}




?>