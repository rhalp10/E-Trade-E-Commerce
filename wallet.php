<?php 
include('dbconfig.php');
session_start();

if (!isset($_SESSION['login_user'])) {
    header('Location:index.php');
}
?>
<!doctype html>
<html lang="en">

<?php 
  include ('x-head.php')
?>
  <body>
 <?php 
 include('x-header.php');
 ?>
 <link rel="stylesheet" type="text/css" href="assets/datatables/datatables.min.css"/>

<main role="main">
<br><br><br>


  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->
  <?php 

   $sql = "SELECT * FROM `user_wallet` WHERE user_ID = '".$_SESSION["login_id"]."'" ;
   $result = mysqli_query($conn, $sql);
 
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
      $uw_Ballance = $row["uw_Balance"];
      }
    }
    else{
      $uw_Ballance = "0";
    }
          ?>
<center>
  <div class="card " style="width: 18rem;">
  <div class="card-body text-left">
    <h5 class="card-title">WALLET</h5>
    <hr>
    <h6 class="card-subtitle mb-2 text-muted">Balance: <?php echo  $uw_Ballance?></h6>
    <button class="btn btn-primary float-right">Recharge</button>
  </div>
  </div>
</center>

<br>
<h3>Latest Activity</h3>
<ul class="list-group">
  <li class="list-group-item text-danger">PHP -900 <div class="float-right text-muted">1hr Ago</div></li>
  <li class="list-group-item text-success">PHP 500 <div class="float-right text-muted">1hr Ago</div></li>
  <li class="list-group-item text-success">PHP 100 <div class="float-right text-muted">1hr Ago</div></li>
  <li class="list-group-item text-success">PHP 500 <div class="float-right text-muted">1hr Ago</div></li>
  <li class="list-group-item text-danger">PHP -1900 <div class="float-right text-muted">1hr Ago</div></li>
  <li class="list-group-item text-success">PHP 500 <div class="float-right text-muted">1hr Ago</div></li>
</ul>
<br>
<!-- Modal -->


<?php 
include('x-footer.php');
?>
</main>
<?php 
include('x-script.php');
?>
<script type="text/javascript" src="assets/datatables/datatables.min.js"></script>
<script type="text/javascript">

$(document).ready(function() {
             
            var dataTable = $('#order_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"dashboard/datatable/order/fetch_order.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });
            $(document).on('click', '.view', function(){
            var order_ID = $(this).attr("id");
            $('#account_modal_title').text('View Order');
            $('#order_modal').modal('show');
   
            
             $.ajax({
                url:"dashboard/datatable/order/fetch_single.php",
                method:'POST',
                data:{action:"order_view",order_ID:order_ID},
                dataType    :   'json',
                success:function(data)
                {


                  $('#acc_username').text(data.user_Name);
                  $('#acc_email').text(data.user_Email);
                  $('#acc_name').text(data.user_Fullname);
                  $('#acc_add').text(data.user_Address);
                  $( "#load_order" ).load( "dashboard/datatable/order/fetchtable.php?order_ID="+order_ID);

                  $('#submit_input').show();
                  $('#account_ID').val(order_ID);
                  $('#submit_input').text('Process');
                  $('#submit_input').val('order_process');
                  $('#operation').val("order_process");
                  
                }
              });


            });
          

});
</script>
</body>
</html>
