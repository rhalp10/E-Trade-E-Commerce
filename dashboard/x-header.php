<!-- <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow"> -->
	 <nav class="navbar  navbar-expand-lg  navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow" >
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="../index">E-Trading</a>
  
<!--   <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="../logout.php">Sign out</a>
    </li>
  </ul> -->

    <ul class="navbar-nav px-3 ml-auto">


       <li class="nav-item  dropdown" id="drophover">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['user_Name']?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
          <a class="dropdown-item" href="profile">Profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="../logout?logout=true">Log Out</a>
        </div>
      </li>
    </ul>
</nav>