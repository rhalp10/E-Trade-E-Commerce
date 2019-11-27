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
    <title>Manage Items</title>


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
        <h1 class="h2">List of Items</h1>
        
      </div>
      <div class="table-responsive">
         <button type="button" class="btn btn-sm btn-success add" data-toggle="modal" data-target="#item_modal">Add</button>
         <br><br>
        <table class="table table-striped table-sm" id="item_data">
          <thead>
            <tr>
              <th>#</th>
              <th>Category</th>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
        </table>


<div class="modal fade" id="item_modal" tabindex="-1" role="dialog" aria-labelledby="item_modal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="item_modal_title">Add New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="item_modal_content">
      <form method="post" id="item_form" enctype="multipart/form-data">
            
             <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="item_img">
                 <img src="../assets/img/uploads/blank.png" class="rounded float-left" alt="..." id="item_img_container" runat="server" style="max-height: 250px; max-width: 250px;  background-repeat:no-repeat;
  background-size:cover;height: auto;
width:auto;">
              </label>
              <input type="file" class="form-control-file" id="item_img" name="item_img">
                </div>
                <div class="form-group col-md-6">
                  <label for="item_stocks_label" id="item_stocks_label">Available:(<i id="item_stocks_count_label"></i>)</label>
                  
                </div>
              </div>
              <div class="form-group">
                <label for="item_name" class="col-form-label">Name:</label>
                <input type="text" class="form-control" id="item_name" name="item_name">
              </div>
              <div class="form-group">
                <label for="item_category">Category</label>
                <select class="form-control" id="item_category" name="item_category">
                  <?php 
                  $sql = "SELECT * FROM `item_category`";

                  $result = mysqli_query($conn, $sql);
                  while ($row = mysqli_fetch_array($result)) {
                  ?>
                  <option value="<?php echo $row["ctgy_ID"];?>"><?php echo $row["ctgy_Name"];?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="item_descr" class="col-form-label">Description:</label>
                <textarea class="form-control" id="item_descr"  name="item_descr"></textarea>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="item_price">Price:</label>
                  <input type="number" class="form-control " id="item_price" name="item_price" value="0"   maxlength="6" >
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="item_weight">Weight(KG):</label>
                  <input type="text" class="form-control " id="item_weight" name="item_weight" value=""   maxlength="6" >
                </div>
              </div>
               <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="item_price">New Price:(5% of Price)</label>
                  <input type="text" class="form-control " id="item_newprice"  value="0"    readonly>
                </div>
              </div>
         
        
           
      </div>
      <div class="modal-footer">
        <input type="hidden" name="item_ID" id="item_ID" />
        <input type="hidden" name="operation" id="operation" />
        <button type="submit" class="btn btn-primary submit" id="item_input" value="item_submit">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
       </form>
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
            function readURL(input) {
        
                  if (input.files && input.files[0]) {
                    var reader = new FileReader();
                
                    reader.onload = function(e) {
                      $('#item_img_container').attr('src', e.target.result);
                    }
                
                    reader.readAsDataURL(input.files[0]);
                  }
                }
                
                $("#item_img").change(function() {
                  readURL(this);
                });


          $(document).ready(function() {
             
            var dataTable = $('#item_data').DataTable({
            "processing":true,
            "serverSide":true,
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

          
          $(document).on('onkeyup change', '#item_price', function(event){
              var item_price = $('#item_price').val();
          
                  var price = parseFloat(item_price);

                  var commision_price =  (0.1 * price) + price;
                  $('#item_newprice').val(commision_price);
            
            });


          $(document).on('submit', '#item_form', function(event){
            event.preventDefault();
           var item_img = $('item_img').val();
            var extension = $('#item_img').val().split('.').pop().toLowerCase();
            if(extension != '')
            {
              if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
              {
                
                alertify.alert("Invalid Image File").setHeader('Item Image');
                $('#item_img').val('');
                return false;
              }
            } 
         
              $.ajax({
                url:"datatable/item/insert.php",
                method:'POST',
                data:new FormData(this),
                contentType:false,
                processData:false,
                success:function(data)
                {
                  alertify.alert(data).setHeader('item');
                  $('#item_form')[0].reset();
                  $('#item_modal').modal('hide');
                  dataTable.ajax.reload();
                }
              });
           
          });

          $(document).on('click', '.add', function(){
            $('#item_modal_title').text('Add New Item');
            $('#item_form')[0].reset();
            $('#item_img_container').attr('src', '../assets/img/uploads/blank.png');
            $("#item_img").show();
            $('#item_input').show();
            $('#item_stocks_label').hide();

            $('#item_input').text('Submit');
            $('#item_input').val('item_submit');
            $('#operation').val("item_submit");
           
            
            
           
          });

          $(document).on('click', '.view', function(){
            var item_ID = $(this).attr("id");
            $('#item_modal_title').text('View Item');
            $('#item_modal').modal('show');

             $.ajax({
                url:"datatable/item/fetch_single.php",
                method:'POST',
                data:{action:"item_view",item_ID:item_ID},
                dataType    :   'json',
                success:function(data)
                {

                $("#item_name").prop("disabled", true);
                $("#item_category").prop("disabled", true);
                $("#item_descr").prop("disabled", true);
                $("#item_price").prop("disabled", true);
                $("#item_weight").prop("disabled", true);
                $("#item_img").hide();
            

                  $('#item_img_container').attr('src', data.item_Img);
                  $('#item_name').val(data.item_Name);
                  $('#item_category').val(data.ctgy_ID).change();
                  $('#item_descr').val(data.item_Description);
                  $('#item_price').val(data.item_Price);
                  $('#item_weight').val(data.item_Weight);
                  $('#item_newprice').val(data.item_NewPrice);

                  $('#item_stocks_count_label').text(data.item_Stocks);
                  $('#item_input').hide();
                  $('#item_stocks_label').show();
                  $('#item_ID').val(item_ID);
                  $('#operation').val("item_view");
                  
                }
              });


            });
            $(document).on('click', '.edit', function(){
            var item_ID = $(this).attr("id");
            $('#item_modal_title').text('View Item');
            $('#item_modal').modal('show');

             $.ajax({
                url:"datatable/item/fetch_single.php",
                type:'POST',
                data:{action:"item_view",item_ID:item_ID},
                dataType    :   'json',
                success:function(data)
                {

                $("#item_name").prop("disabled", false);
                $("#item_category").prop("disabled", false);
                $("#item_descr").prop("disabled", false);
                $("#item_price").prop("disabled", false);
                $("#item_weight").prop("disabled", false);
           
            

                  $('#item_img_container').attr('src', data.item_Img);
                  $('#item_name').val(data.item_Name);
                  $('#item_category').val(data.ctgy_ID).change();
                  $('#item_descr').val(data.item_Description);
                  $('#item_price').val(data.item_Price);
                  $('#item_weight').val(data.item_Weight);
                  $('#item_newprice').val(data.item_NewPrice);
                  $('#item_stocks_count_label').text(data.item_Stocks);
                  
                  $('#item_stocks_label').show();
                  $('#item_input').show();
                  $('#item_input').text('Update');
                  $('#item_input').val('item_edit');
                  $('#operation').val("item_edit");
                  $('#item_ID').val(item_ID);
                  
                }
              });


            });
            $(document).on('click', '.delete', function(){
              var item_ID = $(this).attr("id");
              alertify.confirm('Are you sure you want to remove this item?', 
              function(){
                  $.ajax({
                 type        :   'POST',
                 url:"datatable/item/insert.php",
                 data        :   {operation:"item_delete",item_ID:item_ID},
                 dataType    :   'json',
                 complete     :   function(data) {
                   $('#delitem_modal').modal('hide');
                   alertify.alert(data.responseText).setHeader('Delete this Item');
                   dataTable.ajax.reload();
                    
                 }
                })

                 dataTable.ajax.reload();
                 alertify.success('Ok') 
               },
              function(){ 
                alertify.error('Cancel')
              }).setHeader('Item');
            });

           


          
          } );


        </script>
        </body>

</html>
