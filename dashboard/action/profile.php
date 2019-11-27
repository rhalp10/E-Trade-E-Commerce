<?php
include('../../dbconfig.php');

session_start();
 function getUserPic($conn,$user_ID){
      
     $query ="SELECT user_Img FROM `user` WHERE user_ID =  '$user_ID' 
     LIMIT 1";
     $result = mysqli_query($conn, $query);
     while($row =  mysqli_fetch_array($result))
     {
       
        if (!empty($row['user_Img'])) {
           $_SESSION['user_Img']  = 'data:image/jpeg;base64,'.base64_encode($row['user_Img']);
         }
         else{
            $_SESSION['user_Img']  = "../assets/img/uploads/blank.png";
         }
            
     }
    
 }
if (isset($_POST['action'])) 
{

	$output = array();
	if($_POST['action'] == "change_password")
	{
		include('../../data-md5.php');
		$user_ID = $_SESSION['login_id'];
		$update_password_old = $_REQUEST["update_password_old"];
		$update_password_new = $_REQUEST["update_password_new"];
		$update_password_newconfirm = $_REQUEST["update_password_newconfirm"];
		

		if($update_password_new === $update_password_newconfirm)
		{

 			$input = "$update_password_old";
			$encrypted = encryptIt($input);
			$sql = "SELECT * FROM `user` WHERE user_ID =  '$user_ID' AND `user_Pass` = '$encrypted'
			LIMIT 1";
			$result = mysqli_query($conn, $sql);
			$userRow =  mysqli_fetch_assoc($result);
			if (mysqli_num_rows($result) > 0) {

					$new_password = encryptIt($update_password_newconfirm);
					
					$sql = "UPDATE `user` SET `user_Pass` = '$new_password' WHERE `user_ID` = '$user_ID'";
					$result = mysqli_query($conn, $sql);

					$output['success'] = "Password successfully change";
			}
			else{
				$output['error'] = "Old Password not match";
			}
		}
		else
		{
			$output['error'] = "Password not match";
		}
		
	}
	//CHANGE PROFILE PICTURE
	else if($_POST['action'] == "change_picture")
	{
		$user_ID = $_SESSION['login_id'];
		if (isset($_FILES['change_profile']['tmp_name'])) 
		{
			$new_img = addslashes(file_get_contents($_FILES['change_profile']['tmp_name']));

			// print_r($_FILES);
			$sql = "UPDATE `user` SET `user_Img` = '$new_img' WHERE `user_ID` = $user_ID ;";
			$result = mysqli_query($conn, $sql);
			
			if(!empty($result))
			{
			    $output['success'] = "Profile Image Succesfully";
			    getUserPic($conn,$user_ID);
			    
			} else {
			    $output['error'] =  "Error updating record: " . mysqli_error($conn);
			}
		}
		else{
			$new_img = '';
		}

	}
	else if ($_POST['action'] == "change_email")
	{
		
		
		
		$update_email =  $_REQUEST["update_email"];
		
		$query ="UPDATE `user` SET `user_Email` = '".$update_email."' WHERE `user`.`user_ID` = ".$_SESSION['login_id'];

		 $result = mysqli_query($conn, $query);

		if(!empty($result))
		{
			$output['success'] ="Succesfully Updated";
		}
		else{
			$output['error'] ="Failed to Update";
		}

	}
	else{
		$output['error'] ="Unexpected Error";
		
	}
	
	
	echo json_encode($output);
	
}

?>