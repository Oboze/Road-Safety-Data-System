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


<!-- custom css -->
    <style>
    .m-r-1em{ margin-right:1em; }
    .m-b-1em{ margin-bottom:1em; }
    .m-l-1em{ margin-left:1em; }
    .mt0{ margin-top:0; }
    </style>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Driver
        <small>Information</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Driver Listing</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->

      <?php
// include database connection
include 'config.php';
 
// delete message prompt will be here
 
// select all data
$query = "SELECT * FROM Driver ORDER BY DriverID DESC";
$stmt = $con->prepare($query);
$stmt->execute();
 
// this is how to get number of rows returned
$num = $stmt->rowCount();
 
// link to create record form
//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New User</a>";
 
//check if more than 0 record found
if($num>0){
/*  echo "<div class='row'>";
      echo  "<div class='col-xs-12'>";
       echo  " <div class='box'>";
        echo  " <div class='box-header'>";
              echo "<h3 class='box-title'>Users List</h3>";

            echo  "<div class='box-tools'>";
             echo  " <div class='input-group input-group-sm hidden-xs' style='width: 150px;'>";
            echo    "<input type='text' name='table_search' class='form-control pull-right' placeholder='Search'>";

                echo " <div class='input-group-btn'>";
                  echo  "<button type='submit' class='btn btn-default'><i class='fa fa-search'></i></button>";
               echo   "</div>";
              echo  "</div>";
             echo "</div>";
            echo "</div>";
           echo "<!-- /.box-header -->";
            echo "<div class='box-body table-responsive no-padding'>";
             echo "<table class='table table-hover'>";
 
    // data from database will be here
  //echo "<table class='table table-hover table-responsive table-bordered'>";//start table*/

        echo  "<div class='row'>";
        echo "<div class='col-sm-12'>";
        echo "<div class='box'>";
         echo   "<div class='box-header'>";
            echo  "<h3 class='box-title'>Drivers </h3><a href='driver.php' class='pull-right btn  btn-danger'> Add Driver </a>";
           echo "</div>";
            echo "<!-- /.box-header -->";
            echo "<div class='box-body'>";
              echo "<table id='example1' class='table table-bordered table-striped'>";
 
    //creating our table heading
    echo "<thead>";
    echo "<tr>";
        echo "<th>First Name</th>";
        echo "<th>Middle Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Gender</th>";
        echo "<th>National ID</th>";
        echo "<th> Action </th>";
    echo "</tr>";
    echo "</thead>";
     
    // table body will be here

    // retrieve our table contents
// fetch() is faster than fetchAll()
// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    // extract row
    // this will make $row['firstname'] to
    // just $firstname only
    extract($row);
     
    // creating new table row per record
    echo "<tr>";
        
        echo "<td>{$Firstname}</td>";
        echo "<td>{$Lastname}</td>";
        echo "<td>{$Middlename}</td>";
        echo "<td>{$Sex}</td>";
        echo "<td>{$National_ID}</td>";
        echo "<td>";
            // read one record 
            echo "<a href='view_driver.php?id={$DriverID}' class='btn btn-info m-r-1em'>View</a>";
             
            // we will use this links on next part of this post
            echo "<a href='updatedriver.php?id={$DriverID}' class='btn btn-primary m-r-1em'>Edit</a>";
 
            // we will use this links on next part of this post
            echo "<a href='#' onclick='delete_user({$DriverID});'  class='btn btn-danger disabled'>Delete</a>";
        echo "</td>";
    echo "</tr>";
}

                 /* <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Gender</th>
                  <th>National ID</th>
                </tr>
                </tfoot>*/
 
// end table
echo "</table>";
     
}
 
// if no records found
else{
    echo "<div class='alert alert-danger'>No records found.</div>";
}
?>
     
                  
              
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