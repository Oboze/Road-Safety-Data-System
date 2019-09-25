<?php 

session_start();
//Checking User Logged or Not

//Checking User Logged or Not
if(empty($_SESSION['user'])){
 header('location:index.php');
}
//Restrict User or Moderator to Access Admin.php page
if($_SESSION['user']['role']=='user'){
 header('location:user.php');
}
if($_SESSION['user']['role']=='moderator'){
 header('location:moderator.php');
}


include 'headeradmin.php';




?>

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
        Administration
        <small>Manage Users</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

        <?php
// include database connection
include 'config.php';
 
// delete message prompt will be here
 
// select all data
$query = "SELECT UserID, Firstname, Lastname, Username, User_role, created_at FROM Users ORDER BY UserID DESC";
$stmt = $con->prepare($query);
$stmt->execute();
 
// this is how to get number of rows returned
$num = $stmt->rowCount();
 
// link to create record form
echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New User</a>";
 
//check if more than 0 record found
if($num>0){

  echo "<div class='row'>";
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
  //echo "<table class='table table-hover table-responsive table-bordered'>";//start table
 
    //creating our table heading
    echo "<tr>";
        echo "<th>UserID</th>";
        echo "<th>First Name</th>";
        echo "<th>Last Name</th>";
        echo "<th>Username</th>";
        echo "<th>User Role</th>";
        echo "<th>Account Created At</th>";
        echo "<th> Action </th>";
    echo "</tr>";
     
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
        echo "<td>{$UserID}</td>";
        echo "<td>{$Firstname}</td>";
        echo "<td>{$Lastname}</td>";
        echo "<td>{$Username}</td>";
        echo "<td>{$User_role}</td>";
        echo "<td>{$created_at}</td>";
        echo "<td>";
            // read one record 
            echo "<a href='read_one.php?id={$UserID}' class='btn btn-info m-r-1em'>Read</a>";
             
            // we will use this links on next part of this post
            echo "<a href='update.php?id={$UserID}' class='btn btn-primary m-r-1em'>Edit</a>";
 
            // we will use this links on next part of this post
            echo "<a href='#' onclick='delete_user({$UserID});'  class='btn btn-danger'>Delete</a>";
        echo "</td>";
    echo "</tr>";
}
 
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
      

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->





<?php include 'footeradmin.php';?>