<?php
include('db.php');
include('function.php');
if(isset($_POST["operation"]))
{

	if($_POST["operation"] == "order_process")
	{	
		$statement = $conn->prepare(
		"UPDATE `order` SET `ors_ID` = '2' WHERE `order`.`or_ID` = '".$_POST["order_ID"]."';"
		);
		$statement->execute();
		$result = $statement->fetchAll();

		echo "Process Complete";
	}


	if($_POST["operation"] == "delete_order")
	{	
		$statement = $conn->prepare(
		"DELETE FROM `order_item` WHERE `order_item`.`or_ID` =  '".$_POST["order_ID"]."';"
		);
		$statement->execute();
		


		$statement1 = $conn->prepare(
		"DELETE FROM `order` WHERE `order`.`or_ID` =  '".$_POST["order_ID"]."';"
		);
		$statement1->execute();
		$result = $statement1->fetchAll();

		if ($statement1->rowCount() > 0 ) {
			echo "Data Delete";
		}
		
	}

	
}
?>

