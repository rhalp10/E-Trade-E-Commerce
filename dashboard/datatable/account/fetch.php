<?php
include('../db.php');
include('../function.php');
$query = '';
$output = array();
$query .= "SELECT *";
$query .= "FROM `user` ua
LEFT JOIN `user_level` `ul` ON `ua`.`lvl_ID` = `ul`.`lvl_ID`";
if(isset($_POST["search"]["value"]))
{
 $query .= 'WHERE user_ID LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR user_Name LIKE "%'.$_POST["search"]["value"].'%" ';
    $query .= 'OR lvl_Name LIKE "%'.$_POST["search"]["value"].'%" ';
}


if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY user_ID DESC ';
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
	$sub_array[] = $row["user_ID"];
	$sub_array[] = check_user_level($conn,$row["lvl_ID"]);
	$sub_array[] = $row["user_Name"];
	$sub_array[] = $row["user_Registered"];

		$sub_array[] = '
<button class="btn btn-info view"  id="'.$row["user_ID"].'">View</button>
<button class="btn btn-primary edit"  id="'.$row["user_ID"].'">Edit</button>
<button class="btn btn-danger delete"  id="'.$row["user_ID"].'">Delete</button>';
// <div class="btn-group">
//   <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
//     Action
//   </button>
//   <div class="dropdown-menu">
//     <a class="dropdown-item view"  id="'.$row["user_ID"].'">View</a>
//     <a class="dropdown-item edit"  id="'.$row["user_ID"].'">Edit</a>
//      <div class="dropdown-divider"></div>
//     <a class="dropdown-item delete" id="'.$row["user_ID"].'">Delete</a>
//   </div>
// </div>
	$data[] = $sub_array;
}
$q = "SELECT * FROM `user`";
$output = array(
	"draw"				=>	intval($_POST["draw"]),
	"recordsTotal"		=> 	$filtered_rows,
	"recordsFiltered"	=>	get_total_all_records($conn,$q),
	"data"				=>	$data
);
echo json_encode($output);

?>



        
