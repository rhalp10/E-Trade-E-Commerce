<?php
include('../db.php');
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "stock_submit")
	{	

		$item_ID = $_POST["item_ID"];
		$item_qnty = $_POST["item_qnty"];
		$sql = "INSERT INTO `item_stocks` (`stock_ID`, `item_ID`, `stock_Qnty`, `stock_Date`) VALUES (NULL, :item_ID, :item_qnty, CURRENT_TIMESTAMP);";
		$statement = $conn->prepare($sql);
			
		$result = $statement->execute(
		array(

				':item_ID'		=>	$item_ID,
				':item_qnty'		=>	$item_qnty
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Added';
		}

		
	}

	if($_POST["operation"] == "stock_edit")
	{

		$stock_ID = $_POST["stock_ID"];
		$item_qnty = $_POST["item_qnty"];
		$sql = "UPDATE `item_stocks` SET `stock_Qnty` = :item_qnty WHERE `stock_ID` = :stock_ID;";
		$statement = $conn->prepare($sql);
			
		$result = $statement->execute(
		array(

				':stock_ID'		=>	$stock_ID,
				':item_qnty'		=>	$item_qnty
			)
		);
		if(!empty($result))
		{
			echo 'Successfully Updated';
		}
	
	}

	if($_POST["operation"] == "stock_delete")
	{
		$statement = $conn->prepare(
			"DELETE FROM `item_stocks` WHERE `stock_ID` = :stock_ID"
		);
		$result = $statement->execute(
			array(
				':stock_ID'	=>	$_POST["stock_ID"]
			)
		);
		
		if(!empty($result))
		{
			echo 'Data Deleted';
		}
		
	
	}
}
?>
