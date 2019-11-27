
<header>
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="index"><img src="assets/img/icon1.png" width="50%" style="max-width:80px; margin-top: -7px; padding: 0px;"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item <?php echo $active_ul_product?>">
          <a class="nav-link" href="products">Shop<?php echo $active_ul_product_span?></a>
        </li>
      </ul>
     <i class="fas fa-shopping-cart"></i>
      <form class="form-inline mt-2 mt-md-0">
     
       
        
        <?php 
        if (isset($_SESSION['login_user'])) {
          ?>
          <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
          
             <a class="btn btn-primary  my-2 my-sm-0" href="#" data-toggle="modal" data-target="#modal_cart" >Cart</a>

            <div class="btn-group" role="group">
              <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $_SESSION['login_user']?>
              </button>
              <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                <?php 
                if ($_SESSION['login_level'] ==  2) {
                  ?>
                  <a class="dropdown-item" href="dashboard">Dashboard</a>
                  <?php
                }
                ?>
                
                <a class="dropdown-item" href="wallet">Wallet</a>
                <a class="dropdown-item" href="dashboard/items">Sell</a>
                <a class="dropdown-item" href="order">Order</a>
                <a class="dropdown-item" href="logout.php">Logout</a>
              </div>
            </div>
          </div>
          <?php
        }
        else{
          ?>
          <div class="btn-group">
          <a class="btn btn-primary  my-2 my-sm-0" href="#" data-toggle="modal" data-target="#modal_cart" >Cart</a>
          <a class="btn btn-success  my-2 my-sm-0" href="authentication" role="button">Login</a>
          </div>
          <?php
        }
        ?>
      </form>
    </div>
  </nav>
</header>