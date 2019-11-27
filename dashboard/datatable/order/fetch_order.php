<?php
include('../db.php');
include('../function.php');
session_start();
$query = '';
$output = array();


$query .= "SELECT *";
$query .= " FROM `order` `ord`
LEFT JOIN `user` `u` ON `ord`.`user_ID` = `u`.`user_ID` 
LEFT JOIN `order_status` `ors` ON `ord`.`ors_ID` = `ors`.`ors_ID`";
$query .= " WHERE  ";

if(isset($_SESSION["login_id"]))
{
 
	$query .= "u.user_ID = '".$_SESSION["login_id"]."'  AND ";
}
if(isset($_POST["search"]["value"]))
{
 $query .= '(user_Fullname LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR ors_Name LIKE "%'.$_POST["search"]["value"].'%" ';
	$query .= 'OR or_Date LIKE "%'.$_POST["search"]["value"].'%") ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY or_ID DESC ';
}
if($_POST["length"] != -1)
{
	$query .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$statement = $conn->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
$data = array();
$filtered_rows = $statement->rowCount();
foreach($result as $row)
{
	

	$sub_array = array();
	$sub_array[] = $row["or_ID"];
	$sub_array[] = $row["user_Fullname"];
	$sub_array[] = "<label class='badge badge-info'>".strtoupper($row["ors_Name"])."</label>";
	$sub_array[] = $row["or_Date"];
	if($row["ors_ID"] == 2) {
		$payment_btn = "";
	}
	else{
		$payment_btn = '<button class="btn btn-success payment"  id="'.$row["or_ID"].'">Payment</button>';
	}
		$sub_array[] = '
	<button class="btn btn-primary view"  id="'.$row["or_ID"].'">View</button>
	'.$payment_btn.'
	';
	$data[] = $sub_array;
}
$q = "SELECT * products u.user_ID
		FROM `order` `ord`
		LEFT JOIN `user` `u` ON `ord`.`user_ID` = `u`.`user_ID` 
		LEFT JOIN `order_status` `ors` ON `ord`.`ors_ID` = `ors`.`ors_ID`";

if(isset($_SESSION["login_id"]))
{
 
	$q .= "
	 	WHERE  u.user_ID = '".$_SESSION["login_id"]."'   ";
}
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($conn,$q),
	"data"				=>	$data
);
echo json_encode($output);

?>



        
