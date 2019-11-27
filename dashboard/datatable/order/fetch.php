<?php
include('../db.php');
include('../function.php');
$query = '';
$output = array();
$query .= "SELECT *";
$query .= " FROM `order` `ord`
LEFT JOIN `user` `u` ON `ord`.`user_ID` = `u`.`user_ID` 
LEFT JOIN `order_status` `os` ON `os`.`ors_ID` = `ord`.`ors_ID` 
";
$query .= " WHERE `ord`.`ors_ID` = '2' AND ";

if(isset($_POST["search"]["value"]))
{
 $query .= '(user_Fullname LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR ors_Name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR or_Date LIKE "%'.$_POST["search"]["value"].'%" )';
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
	$sub_array[] = "<label class='badge badge-success'>".strtoupper($row["ors_Name"])."</label>";
	$sub_array[] = $row["or_Date"];

		$sub_array[] = '

    <button class="btn btn-primary approve"  id="'.$row["or_ID"].'">Approve</button>
    <button class="btn btn-danger disapprove"  id="'.$row["or_ID"].'">Disapprove</button>
';
// <div class="btn-group">
//   <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//     Action
//   </button>
//   <div class="dropdown-menu">
//     <a class="dropdown-item approve"  id="'.$row["or_ID"].'">Approve</a>
//     <a class="dropdown-item delete"  id="'.$row["or_ID"].'">Delete</a>
//   </div>
// </div>
	$data[] = $sub_array;
}
$q = "SELECT * FROM `order` `ord`
		LEFT JOIN `user` `u` ON `ord`.`user_ID` = `u`.`user_ID`
		 WHERE `rd`.`ors_ID` = '1'";

$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($conn,$q),
	"data"				=>	$data
);
echo json_encode($output);

?>



        
