<?php 

		include('dbconfig.php');
		include('data-md5.php');
		$output = array();

		$acc_username = $_POST["acc_username"];
		$acc_name = $_POST["acc_name"];
		
		$acc_email = $_POST["acc_email"];
		$acc_pass = $_POST["acc_pass"];
		$acc_cpass = $_POST["acc_cpass"];
		$acc_address = $_POST["acc_add"];

		$acc_username = stripslashes($acc_username);
		$acc_name =stripslashes($acc_name);
	
		$acc_email = stripslashes($acc_email);
		$acc_pass = stripslashes($acc_pass);
		$acc_cpass = stripslashes($acc_cpass);
		$acc_address = stripslashes($acc_address);

		$acc_username = mysqli_real_escape_string($conn,$acc_username);
		$acc_name = mysqli_real_escape_string($conn,$acc_name);
		$acc_email =mysqli_real_escape_string($conn,$acc_email);
		$acc_pass = mysqli_real_escape_string($conn,$acc_pass);
		$acc_cpass = mysqli_real_escape_string($conn,$acc_cpass);
		$acc_address = mysqli_real_escape_string($conn,$acc_address);


		if ($acc_pass != $acc_cpass) {
			$output['error'] =  "Password not match";
		}
		else{
			$newpass = encryptIt($acc_pass);
		
			$sql = "SELECT * FROM `user` WHERE user_Name = '$acc_username'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) > 0) {
				$output['error'] =  'Username already used';
			    
			} 
			else {
			   $sql = "INSERT INTO `user` (
						`user_ID`,
						`lvl_ID`,
						`user_img`,
						`user_Fullname`,
						`user_Name`,
						`user_Pass`,
						`user_Email`,
						`user_Address`,
						`user_Registered`)
						VALUES (
						NULL,
						1,
						NULL,
						'$acc_name',
						'$acc_username',
						'$newpass',
						'$acc_email',
						'$acc_address',
						CURRENT_TIMESTAMP);";
				
				if ($result = mysqli_query($conn, $sql)) {
					$output['success'] =  'Successfully Register';
				}
				else{
					$output['error'] =  'Failed to  Register';
				}
				
			}

		}
		echo json_encode($output,true);
?>