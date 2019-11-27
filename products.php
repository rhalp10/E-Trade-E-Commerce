<?php 
include('dbconfig.php');
session_start();
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
 <style type="text/css">
   #prod_minus:hover{
    background-color: #dc3545;
    color: white;
   }
   #prod_plus:hover{
    background-color: #28a745;
    color: white;
   }
 </style>

<main role="main">

  <section class="jumbotron text-center">
    <div class="container">

      <h1 class="jumbotron-heading">LIST OF ITEM</h1>
  
    </div>
  </section>


  <div class="album py-5 bg-secondary">
    <div class="container">
      
    <div class="input-group mb-3">
      <input type="text" class="form-control" id="search_item" placeholder="SEARCH..." aria-describedby="basic-addon2">
      <div class="input-group-append">
        <span class=" btn btn-primary" id="search_item_click">SEARCH</span>
      </div>
    </div>
    </div>
  </div>
  <div class="album py-5 bg-secondary">
    <div class="container">
      <div class="row">
        <div id="item_container"></div>
      </div>
    </div>
  </div>



</main>
<!-- Modal -->
<div class="modal fade" id="ActionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" id="modal_header">
        <h5 class="modal-title" id="ActionModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         <div class="row">
        <div class="col-md-6">
           <img  class="bd-placeholder-img card-img-top" src="assets/img/uploads/blank.png" width="100%" height="100%" id="modal_prodImg">
        </div>
        <div class="col-md-6">
          <h6 id="modal_prodName"></h6>
          <div id="modal_prodQnty"></div>
          <hr>
          <p id="modal_prodDescription"></p>
         
            <div id="modal_prodPrice"><b>PRICE:</b> &#x20b1; 180 Per KG </div>
            
        
           <div class="input-group mb-3"  style="width: 150px;">

              <div class="input-group-prepend">
                <span class="input-group-text" id="prod_minus">-</span>
              </div>
              <input type="text" class="form-control text-center" aria-label="" id="item_number" value="1"  pattern="\d*" maxlength="4" onkeypress="return isNumberKey(event)">
              <div class="input-group-append">
                <span class="input-group-text" id="prod_plus" >+</span>
              </div>
            </div>
         
            <button type="button" class="btn btn-sm btn-warning" id="addtoCart">Add to Cart</button>
        </div>
      </div>
      </div>
      <div class="modal-footer">
           <input type="hidden" name="mprod_ID" id="mprod_ID" value="">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php 
include('x-footer.php');
include('x-script.php');
?>
<script type="text/javascript">
item_data();
function item_data(search){
      $.ajax({
            type        :   'POST',
            url:"action-data.php",
            data        :   {action:"fetch_items",search:search},
            dataType    :   'html',
            success     :   function(data) {
              $('#item_container').html(data);
            }
        });
}
  
  $(document).on('click', '#search_item_click', function(event){
      var search = $('#search_item').val();
      item_data(search);

  });





$(document).on('click', '#view_prod', function(){

    var data_id = $(this).data('id');
 
     var mh = document.getElementById("modal_header");
        mh.className = mh.className.replace(/\bbg-primary\b/g, "");
        mh.className = mh.className.replace(/\bbg-danger\b/g, "");
        $('#modal_header').css("color","white");
        mh.classList.add("modal-header");
        mh.classList.add("bg-info");
        $('#ActionModalLabel').html('View');
        $('#modal-loading').show();
        $.ajax({
            type        :   'POST',
            url:"action-data.php",
            data        :   {action:"product_view",data_id:data_id},
            dataType    :   'json',
            complete     :   function(data) {
              
              $("#mprod_ID").val(data_id);
              $("#modal_prodImg").attr("src",data.responseJSON.item_Img);
              $('#modal_prodName').html(data.responseJSON.item_Name);
              $('#modal_prodDescription').text(data.responseJSON.item_Description);
              $('#modal_prodPrice').html('<b>PRICE:</b> &#x20b1; '+data.responseJSON.item_Price+' ');
              $('#modal_prodQnty').html('Available: (<i id="avQnty">'+data.responseJSON.item_Qnty+'</i>) ');
              $('#modal_prodSeason').text(data.responseJSON.prod_Season);
            
               
            }
        })



  
});
$(document).on('click', '#addcart_prod', function(){

    var data_id = $(this).data('id');
 
     var mh = document.getElementById("modal_header");
        mh.className = mh.className.replace(/\bbg-primary\b/g, "");
        mh.className = mh.className.replace(/\bbg-danger\b/g, "");
        $('#modal_header').css("color","white");
        mh.classList.add("modal-header");
        mh.classList.add("bg-info");
        $('#ActionModalLabel').html('Add to Cart');
        $('#modal-loading').show();
        $.ajax({
            type        :   'POST',
            url:"action-data.php",
            data        :   {action:"product_view",data_id:data_id},
            dataType    :   'json',
            complete     :   function(data) {
              $("#mprod_ID").val(data_id);
              $("#modal_prodImg").attr("src",data.responseJSON.item_Img);
              $('#modal_prodName').html(data.responseJSON.item_Name);
              $('#modal_prodDescription').text(data.responseJSON.item_Description);
              $('#modal_prodPrice').html('<b>PRICE:</b> &#x20b1; '+data.responseJSON.item_Price+'');
              $('#modal_prodQnty').html('Available: (<i id="avQnty">'+data.responseJSON.item_Qnty+'</i>)');
           
            
               
            }
        })
  
});
$(document).on('onkeyup change', '#item_number', function(){
    var avQnty = $('#avQnty').html();
    var item_number = $('#item_number').val();
    
    if (item_number > avQnty){
         $('#item_number').val(avQnty);
    }
    else{
      $('#item_number').val(item_number);
    }
  });


 $(document).on('click', '#prod_minus', function(){
  var item_qty = $('#item_number').val();
 
 
  
  if (item_qty <= 1) {

  }
 
  else{
      var  new_item_qty = item_qty - 1;
    $('#item_number').val(new_item_qty);
  }

  
});
  $(document).on('click', '#prod_plus', function(){
     var item_qty = $('#item_number').val();
     var avQnty = $('#avQnty').text();

  if (isNaN(item_qty)) {
    $('#item_number').val('1');
  }
  else {
      if (parseInt(avQnty) == parseInt(item_qty)){

  }
 
  else{
var  new_item_qty = parseInt(item_qty) + 1;
  
   
    $('#item_number').val(new_item_qty);
  }
  }
 
    
  
  
});




  $(document).on('click', '#addtoCart', function(){
   
    alertify.confirm("Are you sure you want to cart this items?",
    function(){

      var item_ID = $("#mprod_ID").val();
      var item_qty = $('#item_number').val();
      $.ajax({
          type        :   'POST',
          url:"action-data.php",
          data        :   {action:"addtoCart",item_ID:item_ID,item_qty:item_qty},
          dataType    :   'json',
          complete     :   function(data) {
            if (data.responseJSON.success) {
              alertify.alert(data.responseJSON.msg).setHeader('Shopping Cart');
              alertify.success('Ok');
              $('#ActionModal').modal('hide');
            }
            else{
               alertify.alert(data.responseJSON.msg).setHeader('Shopping Cart');
              alertify.error('Add to Cart Error');
            }
          }
      });
    },
    function(){
      alertify.error('Cancel');
    }).setHeader('Add to Cart');


    });




</script>

</body>
</html>
