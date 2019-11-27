<?php 
include('../session.php');


if ($_SESSION['login_level'] !=  1) {
    header('Location: ../index.php');
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="developer" content="Rhalp Darren R. Cabrera">
    <meta name="generator" content="Jekyll v3.8.5">
    
    <link rel="icon" href="../assets/img/logo.png" type="image/x-icon">
    <title>Manage stock</title>


  <?php 
  include('x-css.php');
  ?>
 



    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="../assets/css/dashboard.css" rel="stylesheet">
  </head>
  <body>
<?php 
  include('x-header.php');
?>

<div class="container-fluid">
  <div class="row">
      <?php 
    include('x-sidenav.php');
    ?>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage stock</h1>
        
      </div>
      <div class="table-responsive">
         <button type="button" class="btn btn-sm btn-success add" data-toggle="modal" data-target="#stocks_modal">Add</button>
         <br><br>
        <table class="table table-striped table-sm" id="stocks_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Date Stock</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            
     
          </tbody>
        </table>


<div class="modal fade" id="stocks_modal" tabindex="-1" role="dialog" aria-labelledby="item_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="stocks_modal_title">Add New Stock</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="item_modal_content">
      <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#item_modal" id="item_browse">BROWSE</button>
      <form method="post" id="stocks_form" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="item_name">Name</label>
                  <input type="text" class="form-control" id="item_name" name="item_name" placeholder="" value="" disabled="">
                </div>
                <div class="form-group col-md-6">
                  <label for="item_qnty">Quantity:</label>
                  <input type="text" class="form-control" id="item_qnty" name="item_qnty" placeholder="" value="">
                </div>
              </div> 
      </div>
      <div class="modal-footer">
        <input type="hidden" name="item_ID" id="item_ID" />
        <input type="hidden" name="stock_ID" id="stock_ID" />
        <input type="hidden" name="operation" id="operation" />
        <button type="submit" class="btn btn-primary submit" id="submit_input" value="stock_submit">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
       </form>
    </div>
  </div>
</div>


<div class="modal fade" id="item_modal" tabindex="-1" role="dialog" aria-labelledby="item_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="item_modal_title">Item List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive" style="overflow-x: hidden;">
        <table class="table table-striped table-sm" id="item_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Category</th>
              <th>Name</th>
              <th>Price</th>
              <th>Weight</th>
              <th>Quantity</th>
              <th>Status</th>
            </tr>
          </thead>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

      </div>
    </main>
  </div>
</div>

<?php 
include('x-script.php');
?>
        <script type="text/javascript">
   


          $(document).ready(function() {
             
            var dataTable = $('#stocks_data').DataTable({
            "processing":true,
            "serverSide":true,
            "order":[],
            "ajax":{
              url:"datatable/stocks/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

          var dataTable_item_data = $('#item_data').DataTable({
            "processing":true,
            "serverSide":true,
            "autoWidth": false,
            "order":[],
            "ajax":{
              url:"datatable/item/fetch.php",
              type:"POST"
            },
            "columnDefs":[
              {
                "targets":[0],
                "orderable":false,
              },
            ],

          });

          dataTable_item_data.column( 6 ).visible( false );
          //----------------------------------------------------------------
          //JQUERY FOR SELECTING ITEM ID WHEN BROWSING
          //----------------------------------------------------------------
            var additem_data = '#item_data tbody';

            $(additem_data).on('click', 'tr', function(){
              
              var cursor = dataTable_item_data.row($(this));//get the clicked row
              var data=cursor.data();// this will give you the data in the current row.

              alertify.confirm("Are you sure you want to stock item data in ("+data[2]+")?",
              function(){
                $('#item_ID').val(data[0]);
                $('#item_name').val(data[2]);
                alertify.success('Detail Used Success');
              },
              function(){
                alertify.error('Cancel');
              }).setHeader('Item Details');

              $('#item_modal').modal('hide');
              
            });


          $(document).on('submit', '#stocks_form', function(event){
            event.preventDefault();

              $.ajax({
                url:"datatable/stocks/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('stock');
                  $('#stocks_form')[0].reset();
                  $('#stocks_modal').modal('hide');
                  dataTable.ajax.reload();
                  dataTable_stocks_data.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#stocks_modal_title').text('Add New Stocks');
            $('#stocks_form')[0].reset();
            $('#submit_input').show();
            $('#item_browse').show();
            $("#item_qnty").prop("disabled", false);
            $('#submit_input').text('Submit');
            $('#submit_input').val('stock_submit');
            $('#operation').val("stock_submit");
          });

          $(document).on('click', '.view', function(){
            var stock_ID = $(this).attr("id");
            $('#stocks_modal_title').text('View Stocks');
            $('#stocks_modal').modal('show');
            $("#item_qnty").prop("disabled", true);
            $('#item_browse').hide();
            
             $.ajax({
                url:"datatable/stocks/fetch_single.php",
                method:'POST',
                data:{action:"stock_view",stock_ID:stock_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $('#item_name').val(data.item_name);
                  $('#item_qnty').val(data.stock_Qnty);
                  $('#submit_input').hide();
                  $('#item_qnty_label').show();
                  $('#stock_ID').val(stock_ID);
                  $('#operation').val("stock_view");
                  
                }
              });


            });
          $(document).on('click', '.edit', function(){
            var stock_ID = $(this).attr("id");
            $('#stocks_modal_title').text('Edit Stocks');
            $('#stocks_modal').modal('show');
            $("#item_qnty").prop("disabled", false);
            $('#item_browse').hide();
            
             $.ajax({
                url:"datatable/stocks/fetch_single.php",
                method:'POST',
                data:{action:"stock_view",stock_ID:stock_ID},
                dataType    :   'json',
                success:function(data)
                {
                  $('#item_name').val(data.item_name);
                  $('#item_qnty').val(data.stock_Qnty);
                  $('#submit_input').show();
                  $('#item_qnty_label').show();
                  $('#stock_ID').val(stock_ID);
                  $('#operation').val("stock_view");
                  $('#submit_input').text('Update');
                  $('#submit_input').val('stock_edit');
                  $('#operation').val("stock_edit");
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
            var stock_ID = $(this).attr("id");
              alertify.confirm('Are you sure you want to remove this stock?', 
              function(){
                $.ajax({
                 type        :   'POST',
                 url:"datatable/stocks/insert.php",
                 data        :   {operation:"stock_delete",stock_ID:stock_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   alertify.alert(data.responseText).setHeader('Delete this Stock');
                   dataTable.ajax.reload();
                    
                 }
                })

                 dataTable.ajax.reload();
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Stocks');
            });

           


      
          
          } );


        </script>
        </body>

</html>
