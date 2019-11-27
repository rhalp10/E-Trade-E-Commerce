<script src="assets/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="assets/js/jquery-3.3.1.min.js" ></script>
      <script>window.jQuery || document.write('<script src="assets/js/jquery-slim.min.js"><\/script>')</script><script src="assets/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
      <script src="assets/alertifyjs/alertify.min.js"></script>
      <script>
      	 $(document).ready(function(){
			  refreshTable();
			});
			 
			function refreshTable(){
			    $('#cart_mbody').load('load_shoppincart.php', function(){
			       setTimeout(refreshTable, 1000);
			    });
			}
		$(document).on('click', '.remove_item', function(){
    
	     var data_id   = $(this).data('id');
	       
	        alertify.confirm("Are you sure you want to remove this items?",
		    function(){
			      $.ajax({
		            type        :   'POST',
		            url:"action-data.php",
		            data        :   {action:"removeitemtoCart",data_id:data_id},
		            dataType    :   'json',
		            complete     :   function(data) {
		              alertify.alert(data.responseJSON.msg).setHeader('Shopping Cart');
		               $('#cart_mbody').load('load_shoppincart.php');
		            }
		        });
		    },
		    function(){
		      alertify.error('Cancel');
		    }).setHeader('Shopping Cart');

	      
	 
	    });
	    $(document).on('click', '#checkout', function(){
		    or_ID = $('#or_ID').val();


		    alertify.confirm("Are you sure you want to checkout this items? Your item will be placed.",
		    function(){
		      if ($('#or_ID').length) {
		        $.ajax({
		            type        :   'POST',
		            url:"action-data.php",
		            data        :   {action:"checkout",or_ID:or_ID},
		            dataType    :   'json',
		            complete     :   function(data) {
		               alertify.alert(data.responseJSON.msg).setHeader('Checkout');
		              if (data.responseJSON.success) {
		                    window.location.assign("order?or_ID="+or_ID);
		              }
		              alertify.success('Ok');
		            }
		        });
		      }
		      else{
		         alertify.alert('You must order first').setHeader('Checkout');
		      }
		    },
		    function(){
		      alertify.error('Cancel');
		    }).setHeader('Shopping Cart');
		      
		  
		});

      </script>
    <?php if ($pagefile_name == "index"): ?>
    <?php endif ?>
    <?php if ($pagefile_name == "products"): ?>
    	<script>
    		    function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
 
         return true;
      }
    	</script>
    <?php endif ?>
  	<?php if ($pagefile_name == "authentication"): ?>
  	<?php endif ?>