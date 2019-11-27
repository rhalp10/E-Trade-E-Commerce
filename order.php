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
<br>


  <!-- Marketing messaging and featurettes
  ================================================== -->
  <!-- Wrap the rest of the page in another container to center all the content. -->

 <table class="table table-striped table-sm" id="order_data">
  <thead>
    <tr>
      <th>#</th>
      <th>Customer</th>
      <th>Status</th>
      <th>Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    

  </tbody>
</table>

<div class="modal fade" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="product_modal_title" aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="account_modal_title">Add Order</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body" id="product_modal_content">
            <form method="post" id="order_form" enctype="multipart/form-data">
               <div class="form-row">
                  <div class="form-group col-md-6">
                     <label for="acc_username">Username</label>
                     <div  id="acc_username" ></div>
                  </div>
                  <div class="form-group col-md-6">
                     <label for="acc_email">Email:</label>
                     <div id="acc_email"></div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="acc_name">Full Name</label>
                     <div id="acc_name"></div>
                  </div>
               </div>
               <div class="form-row">
                  <div class="form-group col-md-12">
                     <label for="acc_add">Address</label>
                     <div id="acc_add"></div>
                  </div>
               </div>
               <div id="load_order">
               </div>
         </div>
         <div class="modal-footer">
         <input type="hidden" name="order_ID" id="order_ID" />
         <input type="hidden" name="operation" id="operation" />
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         </div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment Gateway</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="payment_wallet-tab" data-toggle="tab" href="#payment_wallet" role="tab" aria-controls="payment_wallet" aria-selected="true">Wallet</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="payment_card-tab" data-toggle="tab" href="#payment_card" role="tab" aria-controls="payment_card" aria-selected="false">Card</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="payment_wallet" role="tabpanel" aria-labelledby="payment_wallet-tab">
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

          $order_total = "550";
          ?>
          <br>
          <h6 class="card-subtitle mb-2 ">Wallet: <?php echo  $uw_Ballance?></h6>
          <h6 class="card-subtitle mb-2 ">Order Payment: <?php echo  $order_total?></h6>
          <h6 class="card-subtitle mb-2 ">Balance: <?php echo  $uw_Ballance - $order_total?></h6>
  </div>
  <div class="tab-pane fade" id="payment_card" role="tabpanel" aria-labelledby="payment_card-tab">
    
  </div>
</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary submit_payment">Submit</button>
      </div>
    </div>
  </div>
</div>

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
    $(document).on('click', '.payment', function(){
                $('#payment').modal('show');
             });

       $(document).on('click', '.submit_payment', function(){
               alertify.confirm('Are you sure you want to proceed this payment?', 
              function(){
                // $.ajax({
                //  type        :   'POST',
                //  url:"datatable/stocks/insert.php",
                //  data        :   {operation:"stock_delete",stock_ID:stock_ID},
                //  dataType    :   'json',
                //  complete     :   function(data) {
                //    alertify.alert(data.responseText).setHeader('Payment thru wallet');
                //    dataTable.ajax.reload();
                    
                //  }
                // })

                 dataTable.ajax.reload();
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Payment Gateway');
             });

    

        
});
</script>
</body>
</html>
