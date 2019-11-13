<?php 

session_start();
//Checking User Logged or Not
if(empty($_SESSION['user'])){
 header('location:index.php');
}
//Restrict admin or Moderator to Access user.php page
if($_SESSION['user']['role']=='admin'){
 header('location:admin.php');
}
if($_SESSION['user']['role']=='moderator'){
 header('location:moderator.php');
}

include 'header.php';
include 'config.php';
?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Quick Links</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <?php
      // statistical queries
      $query="SELECT Count(Sex) AS Male_Drivers From Driver Where Sex='Male'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $maleDriversTotal=$stmt->fetch(PDO::FETCH_ASSOC);

      $query="SELECT Count(Sex) AS Female_Drivers From Driver Where Sex='Female'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $femaleDriversTotal=$stmt->fetch(PDO::FETCH_ASSOC);


      $query="SELECT Count(Driver.DriverID) AS GoodMaleDrivers From Driver Left Join Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID IS NULL AND Driver.Sex='Male'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $goodMaleDrivers=$stmt->fetch(PDO::FETCH_ASSOC);



      $query="SELECT Count(Driver.DriverID) AS GoodFemaleDrivers From Driver Left Join Offence ON Driver.DriverID=Offence.DriverID WHERE Offence.OffenseID IS NULL AND Driver.Sex='Female'";
      $stmt=$con->prepare($query);
      $stmt->execute();

      $goodFemaleDrivers=$stmt->fetch(PDO::FETCH_ASSOC);


      ?>

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
       <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Reports</h3>

              <p>Accidents</p>
            </div>
            <div class="icon">
              <i class="ion ion-podium"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>Search<sup style="font-size: 20px"></sup></h3>

              <p>Advanced Search</p>
            </div>
            <div class="icon">
              <i class="ion ion-search"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>Settings</h3>

              <p>User Profile</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Reports</h3>

              <p>Traffic Offences</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->


      
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include 'footer.php'?>