<?php
include('../db.php');
include('../function.php');
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "account_submit")
	{	
		
		

		$acc_username = $_POST["acc_username"];
		$acc_name = $_POST["acc_name"];
		$acc_lvl = $_POST["acc_lvl"];
		$acc_email = $_POST["acc_email"];
		$acc_pass = $_POST["acc_pass"];
		$acc_cpass = $_POST["acc_cpass"];
		$acc_address = $_POST["acc_add"];

		if ($acc_pass != $acc_cpass) {
			echo "Password not match";
		}
		else{
			$newpass = encryptIt($acc_pass);
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
			:acc_lvl,
			NULL,
			:acc_name,
			:acc_username,
			:acc_pass,
			:acc_email,
			:acc_address,
			CURRENT_TIMESTAMP);";
			$statement = $conn->prepare($sql);
				
			$result = $statement->execute(
			array(

					':acc_username'		=>	$acc_username ,
					':acc_name'		=>	$acc_name ,
					':acc_lvl'		=>	$acc_lvl ,
					':acc_email'		=>	$acc_email ,
					':acc_pass'			=>	$newpass ,
					':acc_address'			=>	$acc_address ,
				)
			);
			if(!empty($result))
			{
				echo 'Successfully Added';
			}
		}
	

		
	}

	if($_POST["operation"] == "account_edit")
	{
		
		

		$account_ID = $_POST["account_ID"];
		$acc_name = $_POST["acc_name"];
		$acc_lvl = $_POST["acc_lvl"];
		$acc_email = $_POST["acc_email"];
		$acc_pass = $_POST["acc_pass"];
		$acc_cpass = $_POST["acc_cpass"];
		$acc_address = $_POST["acc_add"];

		if ($acc_pass != $acc_cpass) {
			echo "Password not match";
		}
		else{
			$newpass = encryptIt($acc_pass);
			$sql = "UPDATE `user` SET `lvl_ID` = :acc_lvl, `user_Fullname` = :acc_name, `user_Pass` = :acc_pass, `user_Email` = :acc_email, `user_Address` = :acc_address WHERE `user`.`user_ID` = :account_ID;";
			$statement = $conn->prepare($sql);
				
			$result = $statement->execute(
			array(

					':account_ID'		=>	$account_ID ,
					':acc_name'		=>	$acc_name ,
					':acc_lvl'		=>	$acc_lvl ,
					':acc_email'		=>	$acc_email ,
					':acc_pass'			=>	$newpass ,
					':acc_address'			=>	$acc_address ,
				)
			);
			if(!empty($result))
			{
				echo 'Successfully Updated';
			}
		}
	
	}

	if($_POST["operation"] == "account_delete")
	{
		$statement = $conn->prepare(
			"DELETE FROM `user` WHERE `user`.`user_ID` = :user_ID"
		);
		$result = $statement->execute(
			array(
				':user_ID'	=>	$_POST["account_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Successfully Deleted';
		}
		
	
	}
}
?>

