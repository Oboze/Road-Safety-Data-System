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


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Details
        <!--<small>Optional description</small>-->
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
        <?php
// get passed parameter value, in this case, the record ID
// isset() is a PHP function used to verify if a value is there or not
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

//include database connection
include 'config.php';
 
// read current record's data
try {
    // prepare select query
    $query = "SELECT UserID, Firstname, Lastname, Username, Password, User_role, created_at FROM Users WHERE UserID = ? LIMIT 0,1";
    $stmt = $con->prepare( $query );
 
    // this is the first question mark
    $stmt->bindParam(1, $id);
 
    // execute our query
    $stmt->execute();
 
    // store retrieved row to a variable
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    // values to fill up our form
    $firstname = $row['Firstname'];
    $lastname = $row['Lastname'];
    $username = $row['Username'];
    //$password=$row['Password'];
    $userrole=$row['User_role'];
    $created=$row['created_at'];
 }  
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}
?>

<div class="row">
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
             
              
              <h3 class='box-title'> </h3><a href='admin.php' class='pull-left btn  btn-danger'> Back to User Listing </a>
           
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            

            

            <div class="col-md-6">
            <p style="font-weight:900; font-size:18px;"> First Name: <span style="font-weight:500;"> <?php echo $firstname?></span> </p>
            <p style="font-weight:900; font-size:18px;"> Last Name: <span style="font-weight:500;"> <?php echo $lastname;?></span> </p>
            <p style="font-weight:900; font-size:18px;"> Username: <span style="font-weight:500;"> <?php echo $username;?></span></p>
            <p style="font-weight:900; font-size:18px;"> User Role: <span style="font-weight:500;"> <?php echo $userrole;?></span></p>
            <p style="font-weight:900; font-size:18px;"> Account Created At: <span style="font-weight:500;"> <?php echo $created;?></span></p>

            </div> 



          </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->



<?php include 'footeradmin.php'; ?>