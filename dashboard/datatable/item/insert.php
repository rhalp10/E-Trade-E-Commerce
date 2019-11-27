<?php
include('../db.php');
include('../function.php');
session_start();
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "item_submit")
	{	
		// error_reporting(0);
	
		$item_img = NULL;
		if ($_FILES['item_img']['error'] != 4) {
			$item_img = file_get_contents($_FILES['item_img']['tmp_name']);
			
		}
	
		$item_name = $_POST["item_name"];
		$item_category = $_POST["item_category"];
		$item_descr = $_POST["item_descr"];
		$item_price = $_POST["item_price"];
		$item_weight = $_POST["item_weight"];

		$sql = "SELECT * FROM `item_details` WHERE `item_name`= :item_name;";
		$statement = $conn->prepare($sql);
		$statement->bindParam(':item_name', $item_name, PDO::PARAM_STR);
		$result = $statement->execute();
		$resultrows = $statement->rowCount();

		if (empty($resultrows)) { 
		   
			 $sql = "INSERT INTO `item_details` (`item_ID`, `user_ID`, `ctgy_ID`, `item_Img`, `item_Name`, `item_Description`, `item_Price`,`item_Weight`, `item_Stocks`, `item_Date`) VALUES (NULL, :login_id, :item_category, :item_img, :item_name, :item_descr, :item_price,:item_weight, '0', CURRENT_TIMESTAMP);";
			$statement = $conn->prepare($sql);
			
			$result = $statement->execute(
				array(

					':login_id'	 			=>	$_SESSION['login_id'],
					':item_category'		=>	$item_category,
					':item_img'				=>	$item_img,
					':item_name'			=>	$item_name,
					':item_descr' 			=>	$item_descr,
					':item_price'	 		=>	$item_price,
					':item_weight'	 		=>	$item_weight,

					
					
				)
			);

			if(!empty($result))
			{
				echo 'Successfully Added';
			}

		} 
		else {
		   // if product is not available
			echo 'This Product Already Added';

		}
	}

	if($_POST["operation"] == "item_edit")
	{
		// error_reporting(0);
		
		$item_img = NULL;
		// print_R($_POST);
		if ($_FILES['item_img']['error'] != 4) {
			$item_img = file_get_contents($_FILES['item_img']['tmp_name']);
		}

		
		
		$item_ID = $_POST["item_ID"];
		$item_name = $_POST["item_name"];
		$item_category = $_POST["item_category"];
		$item_descr = $_POST["item_descr"];
		$item_price = $_POST["item_price"];
		$item_weight = $_POST["item_weight"];

		if (empty($item_img)) {
		 	$sql = "UPDATE `item_details` 
			SET 
			`ctgy_ID`  = :item_category,
			 `item_Name` = :item_name,
			  `item_Description` = :item_descr,
			   `item_Price` = :item_price,
			    `item_Weight` = :item_weight 
			    WHERE `item_ID` = :item_ID";
			$statement = $conn->prepare($sql);
			
			$result = $statement->execute(
				array(

					':item_ID'				=>	$item_ID,
					':item_category'		=>	$item_category,
					':item_name'			=>	$item_name,
					':item_descr' 			=>	$item_descr,
					':item_price'	 		=>	$item_price,
					':item_weight'	 		=>	$item_weight,
					
					
				)
			);
		}
		else{

		 	$sql = "UPDATE `item_details` 
			SET 
			`ctgy_ID`  = :item_category,
			 `item_Img`  = :item_img,
			  `item_Name` = :item_name,
			   `item_Description` = :item_descr,
			    `item_Price` = :item_price,
			     `item_Weight` = :item_weight 
			     WHERE `item_ID` = :item_ID";
			$statement = $conn->prepare($sql);
			
			$result = $statement->execute(
				array(

					':item_ID'		=>	$item_ID,
					':item_category'		=>	$item_category,
					':item_img'				=>	$item_img,
					':item_name'			=>	$item_name,
					':item_descr' 			=>	$item_descr,
					':item_price'	 		=>	$item_price,
					':item_weight'	 		=>	$item_weight,
					
					
				)
			);
		}	

		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
	
	}

	if($_POST["operation"] == "item_delete")
	{
		


		$statement = $conn->prepare(
			"DELETE FROM `item_details` WHERE `item_ID` = :item_ID"
		);
		$result = $statement->execute(
			array(
				':item_ID'	=>	$_POST["item_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Item Deleted';
		}
		
	
	}
}
?>
