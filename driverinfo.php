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



include 'header.php' ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver
        <small>Information</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      <div class="row">
        <div class="col-sm-12">
        <div class="box">
            <div class="box-header">
              <h3 class="box-title">Drivers </h3><a href="driver.php" class="pull-right btn btn-info"> Add Driver </a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Gender</th>
                  <th>Age</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Stephen</td>
                  <td>Maringu</td>
                  <td>Nandi</td>
                  <td> Male</td>
                  <td>32</td>
                </tr>
                <tr>
                  <td>Mario</td>
                  <td>Ochieng
                  </td>
                  <td>Balotelli</td>
                  <td>Male</td>
                  <td>28</td>
                </tr>
                <tr>
                  <td>Stephen</td>
                  <td>Maxwell
                  </td>
                  <td>Richards</td>
                  <td>Male</td>
                  <td>45</td>
                </tr>
                <tr>
                  <td>Mary</td>
                  <td>Magdelene
                  </td>
                  <td>Azere</td>
                  <td>Female</td>
                  <td>34</td>
                </tr>
                <tr>
                  <td>Ariza</td>
                  <td>Castellano</td>
                  <td>Grizemann</td>
                  <td>Male</td>
                  <td>23</td>
                </tr>
               
                
                </tbody>
                <tfoot>
                <tr>
                  <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Gender</th>
                  <th>Age</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php include 'footer.php'?>