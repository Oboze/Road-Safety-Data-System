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
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        This Driver
        <small>Details of Motorist</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="driverinfo.php"></i> Driver Listing</a></li>
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
    $query = "SELECT DriverID, Firstname, Lastname, Middlename, DOB, Sex, Address, National_ID, PassportNO, image FROM Driver WHERE DriverID = ? LIMIT 0,1";
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
    $middlename = $row['Middlename'];
    $dob=$row['DOB'];
    $sex=$row['Sex'];
    $address=$row['Address'];
    $nationalid=$row['National_ID'];
    $passport=$row['PassportNO'];
    $image = htmlspecialchars($row['image'], ENT_QUOTES);
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}

$penaltyscore=0;

if ($penaltyscore===NULL){
    $penaltyscore="No Score Yet";
}else{

$totalSumQuery = "SELECT SUM(Risk_Score) AS Penalty FROM Offence WHERE DriverID=?";
$stmt1 = $con->prepare($totalSumQuery);

$stmt1->bindParam(1, $id);
$stmt1->execute();

$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

$penaltyscore=$row1['Penalty'];
}




?>

<div class="row">
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              
              
              <h3 class='box-title'><?php echo $firstname." ".$middlename." ".$lastname?> </h3> 
              <div class="btn-group pull-right">
              <a href='addoffence.php' class='btn  btn-danger'> Add Traffic Violation/Offence Record </a>
              <a href='driverinfo.php' class='btn  btn-danger'> Back to Drivers Listing </a>
            </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            <div class="row">
              <div class="col-md-4"> 

            <?php echo $image ? "<img src='uploads/{$image}' style='width:235px; height:265px;' />" : "No image found.";  ?>
    </td>
            </div>

            <?php

            $today = date("Y-m-d");
            $diff = date_diff(date_create($dob), date_create($today));
            //echo 'Age is '.$diff->format('%y');


            $_SESSION['driverid']=$id;

            ?>

            <div class="col-md-4">
            <p style="font-weight:900; font-size:16px;"> Date of Birth: <span style="font-weight:500;"> <?php echo $dob?></span> </p>
            <p style="font-weight:900; font-size:16px;"> Age: <span style="font-weight:500;"> <?php echo $diff->format('%y');?></span> </p>
            <p style="font-weight:900; font-size:16px;"> Gender: <span style="font-weight:500;"> <?php echo $sex?></span></p>
            <p style="font-weight:900; font-size:16px;"> Address: <span style="font-weight:500;"> <?php echo $address?></span></p>
            <p style="font-weight:900; font-size:16px;"> National ID: <span style="font-weight:500;"> <?php echo $nationalid?></span></p>

            </div> 

            <div class="col-md-4">
            <p style="font-weight:900; font-size:16px;"> Risk Score: <span style="font-weight:500;"> <?php echo $penaltyscore?></span> </p>
            

            </div> 


          </div>

              
            </div>
            <!-- /.box-body -->
            <div class="box-footer box-comments">
              <div class="box-comment">
                <!-- User image -->
                

                
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
              <div class="box-comment">
                <!-- User image -->

                <?php

 
// delete message prompt will be here
 
// select all data
$query = "SELECT * FROM Offence WHERE DriverID=? ORDER BY Date DESC";
$stmt = $con->prepare($query);

$stmt->bindParam(1, $id);
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
       // echo "<div class='box'>";
         //echo   "<div class='box-header'>";
            echo  "<h4 class='box-title' style='text-align:center;'>Offences Committed ($num) </h3>";
           echo "</div>";
           //s echo "<!-- /.box-header -->";
            echo "<div class='box-body'>";
             // echo "<table id='example1' class='table table-bordered table-striped'>";
              echo "<table class='table table-bordered table-striped'>";
 
 
    //creating our table heading
    echo "<thead>";
    echo "<tr>";
        
        echo "<th>Offence Type</th>";
        echo "<th>Date</th>";
        echo "<th>Time</th>";
        echo "<th>Description</th>";
       // echo "<th> Action </th>";
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
        
        
        echo "<td>{$Offence_Type}</td>";
        echo "<td>{$Date}</td>";
        echo "<td>{$Time}</td>";
        echo "<td>{$Description}</td>";
        /*echo "<td>";
            // read one record 
            echo "<a href='view_driver.php?id={$DriverID}' class='btn btn-info m-r-1em'>View</a>";
             
            // we will use this links on next part of this post
            echo "<a href='updatedriver.php?id={$DriverID}' class='btn btn-primary m-r-1em'>Edit</a>";
 
            // we will use this links on next part of this post
            echo "<a href='#' onclick='delete_user({$DriverID});'  class='btn btn-danger disabled'>Delete</a>";
        echo "</td>";*/
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
    echo "<div class='alert alert-success'>Drivers Offence Record is Clean! Hurray!.</div>";
}
?>
                
                
              </div>
              <!-- /.box-comment -->
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
              
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->









    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->









<?php include 'footer.php';?>