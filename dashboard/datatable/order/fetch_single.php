<?php
include('../db.php');
// include('function.php');

if (isset($_POST['action'])) {
	
	$output = array();
	$statement = $conn->prepare(
		"SELECT * FROM `order` `ord` 
		LEFT JOIN `user`  `u` ON `ord`.user_ID = `u`.user_ID
		WHERE `ord`.`or_ID` =  '".$_POST["order_ID"]."' 
				LIMIT 1"
	);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{

		if (!empty($row['user_img'])) {
				
			 $output["ac_Img"] = 'data:image/jpeg;base64,'.base64_encode($row['user_img']);
			}
			else{
			  $output["ac_Img"] = "../assets/img/uploads/blank.png";
			}
		
		$output["ors_ID"] = $row["ors_ID"];
		$output["user_Fullname"] = $row["user_Fullname"];
		$output["user_Name"] = $row["user_Name"];
		$output["user_Email"] = $row["user_Email"];
		$output["user_Address"] = $row["user_Address"];
	
	}
	echo json_encode($output);
	
}
?>