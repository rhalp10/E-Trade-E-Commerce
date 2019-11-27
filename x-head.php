<?php 
 $current_url = $_SERVER['REQUEST_URI'];
$url_explde = explode('/', $current_url);
$pagefile_name = $url_explde[2];
$page_title = "Index";
if ($pagefile_name == 'products') {
  $page_title = "Products";
  $active_ul_product = "active";
  $active_ul_product_span = '<span class="sr-only">(current)</span>';
}
else if ($pagefile_name == 'index') {
  $page_title = "Index";
   $active_ul_product = '';
  $active_ul_product_span = '';
}
else if ($pagefile_name == 'authentication') {
  $page_title = "Authentication";
   $active_ul_product = '';
  $active_ul_product_span = '';
}
else{
   $active_ul_product = '';
  $active_ul_product_span = '';
}




?>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="developer" content="Rhalp Darren R. Cabrera">
    <meta name="generator" content="Jekyll v3.8.5">
    <title><?php echo $page_title;?></title>

    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">



    <?php if ($pagefile_name == "index" or  $pagefile_name == NULL  or (preg_match( '/^order.*/', $pagefile_name)) or (preg_match( '/^index.*/', $pagefile_name))): ?>
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
    <link href="assets/css/carousel.css" rel="stylesheet">
    <?php endif ?>
  <?php if ($pagefile_name == "products"  or (preg_match( '/^products.*/', $pagefile_name))) : ?>
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
    <link href="assets/css/album.css" rel="stylesheet">
    <?php endif ?>
  <?php if ($pagefile_name == "authentication"  or (preg_match( '/^authentication.*/', $pagefile_name))): ?>
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
    <link href="assets/css/floating-labels.css" rel="stylesheet">
  <?php endif ?>
  <!-- include the style -->
  <link rel="stylesheet" href="assets/alertifyjs/css/alertify.min.css" />
  <!-- include a theme -->
  <link rel="stylesheet" href="assets/alertifyjs/css/themes/default.min.css" />
  </head>