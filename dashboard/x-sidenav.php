<?php 
echo $current_url = $_SERVER['REQUEST_URI'];
$url_explde = explode('/', $current_url);
$pagefile_name = $url_explde[3];

function navlist($pagefile_name,$name,$link,$icon){
 
  if ($pagefile_name == $link) {
    $active_ul_snav = "active";
    $active_ul_snav_span = '<span class="sr-only">(current)</span>';
    
  }
  else{
     $active_ul_snav = '';
      $active_ul_snav_span = '';
  }
  ?>
   <li class="nav-item">
            <a class="nav-link <?php echo $active_ul_snav;?>" href="<?php echo $link;?>">
              <span data-feather="<?php echo $icon;?>"></span>
              <?php echo $name.' '.$active_ul_snav_span; ?>
            </a>
          </li>
  <?php
}
?>
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <?php 
          navlist($pagefile_name,"Dashboard","index","home");
          if($_SESSION['login_level'] == 1){

          navlist($pagefile_name,"Stocks","stocks","file");
          navlist($pagefile_name,"Items","items","shopping-cart");
          }
          else{
          navlist($pagefile_name,"Account","account","users");
          navlist($pagefile_name,"Transaction","transaction","file");
          }
           
          ?>
        </ul>
      </div>
    </nav>