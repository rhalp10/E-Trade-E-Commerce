<?php 
include('../session.php');


// if ($_SESSION['login_level'] !=  2) {
//     header('Location: ../index.php');
// }
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
    <title>Index</title>


    <!-- Bootstrap core CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


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
        <h1 class="h2">Dashboard</h1>
      </div>
      <?php 
        if($_SESSION['login_level'] == 1){
          ?> <h4>Line Chart Sales</h4><?php
        }
        else{
          ?> <h4>Commision Chart Sales</h4><?php
        }
      ?>
     
      <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
    </main>
  </div>
</div>
<script src="../assets/js/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../assets/js/jquery-slim.min.js"><\/script>')</script><script src="../assets/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
        <script src="../assets/js/feather.min.js"></script>
        <script src="../assets/js/Chart.min.js"></script>
        <?php 
        if($_SESSION['login_level'] == 1){
          ?>
          <script>
           (function () {
          'use strict'

            feather.replace()
          // SELECT * FROM `order` WHERE ors_ID = 3
            // Graphs
            var ctx = document.getElementById('myChart')
            // eslint-disable-next-line no-unused-vars
            var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: [
             
                  'May',
                  'June',
                  'July',
                  'August',
                  'September',
                  'October',
                  'November'
                ],
                datasets: [{
                  data: [
                    9,
                    4,
                    1,
                    5,
                    3,
                    6,
                    3
                  ],
                  lineTension: 0,
                  backgroundColor: 'transparent',
                  borderColor: '#007bff',
                  borderWidth: 4,
                  pointBackgroundColor: '#007bff'
                }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: false
                    }
                  }]
                },
                legend: {
                  display: false
                }
              }
            })
          }())

          </script>
          <?php
        }
        else{
          ?>
            <script>
           (function () {
          'use strict'

            feather.replace()
          // SELECT * FROM `order` WHERE ors_ID = 3
            // Graphs
            var ctx = document.getElementById('myChart')
            // eslint-disable-next-line no-unused-vars
            var myChart = new Chart(ctx, {
              type: 'line',
              data: {
                labels: [
             
                  'May',
                  'June',
                  'July',
                  'August',
                  'September',
                  'October',
                  'November'
                ],
                datasets: [{
                  data: [
                    1,
                    4,
                    1,
                    10,
                    3,
                    1,
                    7
                  ],
                  lineTension: 0,
                  backgroundColor: 'transparent',
                  borderColor: '#007bff',
                  borderWidth: 4,
                  pointBackgroundColor: '#007bff'
                }]
              },
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: false
                    }
                  }]
                },
                legend: {
                  display: false
                }
              }
            })
          }())

          </script>
          <?php

        }?>
        <!-- <script src="../assets/js/dashboard.js"></script> -->
      </body>
</html>
