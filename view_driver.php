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
    $query = "SELECT DriverID, Firstname, Lastname, Middlename, DOB, Sex, Address, National_ID, Training, LicenseNO, image FROM Driver WHERE DriverID = ? LIMIT 0,1";
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
    $training=$row['Training'];
    $license=$row['LicenseNO'];

    $image = htmlspecialchars($row['image'], ENT_QUOTES);
}
 
// show error
catch(PDOException $exception){
    die('ERROR: ' . $exception->getMessage());
}

$penaltyscore=0;



$totalSumQuery = "SELECT SUM(Risk_Score) AS Penalty FROM Offence WHERE DriverID=?";
$stmt1 = $con->prepare($totalSumQuery);

$stmt1->bindParam(1, $id);
$stmt1->execute();

$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);

$penaltyscore=$row1['Penalty'];

if ($penaltyscore===NULL){
    $penaltyscore="No Points";
    $accidentrisk="Very Low Risk";
}elseif($penaltyscore>0 && $penaltyscore<=5){
  $accidentrisk="Low Risk";
}elseif($penaltyscore>5 && $penaltyscore<=12){
  $accidentrisk="Moderate Risk";
}elseif($penaltyscore>12 && $penaltyscore<=25){
  $accidentrisk="High Risk";
}elseif($penaltyscore>25){
  $accidentrisk="Dangerous";
}




?>

<div class="row">
        <div class="col-md-12">
          <!-- Box Comment -->
          <div class="box box-widget">
            <div class="box-header with-border">
              
              
              <h3 class='box-title'><?php echo $firstname." ".$middlename." ".$lastname?> </h3> 
              <div class="btn-group pull-right">
              <a href='addoffence.php' class='btn  bg-olive'> Create Offence Record Only</a>
              <a href='addaccident.php' class='btn bg-purple'> Create Offence and Accident Record</a>
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
            <p style="font-weight:900; font-size:16px;"> Gender: <span style="font-weight:500;"> <?php echo $sex;?></span></p>
            <p style="font-weight:900; font-size:16px;"> Address: <span style="font-weight:500;"> <?php echo $address;?></span></p>
            <p style="font-weight:900; font-size:16px;"> National ID: <span style="font-weight:500;"> <?php echo $nationalid;?></span></p>
            <p style="font-weight:900; font-size:16px;"> Driver Training: <span style="font-weight:500;"> <?php echo $training;?></span></p>
            <p style="font-weight:900; font-size:16px;"> License Number: <span style="font-weight:500;"> <?php echo $license;?></span></p>

            </div> 

            <div class="col-md-4">
            <p style="font-weight:900; font-size:16px;"> Penalty Score: <span style="font-weight:500;"> <?php echo $penaltyscore;?></span> </p>
            <p style="font-weight:900; font-size:16px;"> Accident Risk: <span style="font-weight:500;"> <?php echo $accidentrisk?></span> </p>
            

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

                
                
                
              </div>
              <!-- /.box-comment -->
            </div>
            <!-- /.box-footer -->
            <div class="box-footer">
              
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        

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

echo  "<div class='row'>";
        echo "<div class='col-sm-12'>";
        echo "<div class='box'>";
        echo   "<div class='box-header'>";
            echo  "<h4 class='box-title' style='text-align:center;'>Offences History ($num) </h3>";
           echo "</div>";
           //s echo "<!-- /.box-header -->";
            echo "<div class='box-body'>";
              //echo "<table id='example1' class='table table-bordered table-striped'>";
              echo "<table class='table table-bordered table-striped'>";
 
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

        
 
 
    //creating our table heading
    echo "<thead>";
    echo "<tr>";
        
        echo "<th>Offence Type</th>";
        echo "<th>Date</th>";
        echo "<th>Time</th>";
       // echo "<th>Description</th>";
        echo "<th>Action Taken</th>";
        echo "<th>Penalty Point</th>";
        echo "<th>View Full Details</th>";
       
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
    //extract($row);

  $offenceID=$row['OffenseID'];
  $offenceType=$row['Offence_Type'];
  $offenceDate=$row['Date'];
  $offenceTime=$row['Time'];
  $description=$row['Description'];
  $riskscore=$row['Risk_Score'];
  $actionTaken=$row['Action_Taken'];
  
  
    // creating new table row per record
    echo "<tr>";
        
        
        echo "<td>$offenceType</td>";
        echo "<td><span class='badge bg-blue'>$offenceDate</span></td>";
        echo "<td><span class='badge bg-red'>$offenceTime</span></td>";
        //echo "<td>$description</td>";




              echo "<td><span class='badge bg-green'>$actionTaken</span></td>";
              echo "<td>$riskscore</td>";

         //echo "<td>";
         ?>
           <td> 
          <!-- <td><a href='#out<?php $offenceID;?>' data-toggle='modal' aria-hidden='true'>-->
          <button  class='btn btn-info m-r-1em  view_data' id="<?php echo $offenceID;?>">View</button>
          
          </td>
        <?php

            extract($row);
            //echo "<td>";
             
            // we will use this links on next part of this post
            //echo "<a href='updateoffence.php?oid={$OffenseID}' class='btn btn-primary m-r-1em'>Edit</a>";
 
            // we will use this links on next part of this post
            //echo "<a href='#' onclick='delete_user({$DriverID});'  class='btn btn-danger disabled'>Delete</a>";
        //echo "</td>";
    echo "</tr>";


                 /* <th>First Name</th>
                  <th>Middle Name</th>
                  <th>Last Name</th>
                  <th>Gender</th>
                  <th>National ID</th>
                </tr>
                </tfoot>*/
 }
// end table
echo "</table>";
     

 
// if no records found
}else{
    echo "<div class='alert alert-success'>Driver's Offence Record is Clean! Hurray!.</div>";
}
?>


</div>

</div>


<?php

 
// delete message prompt will be here
 
// select all data
$query = "SELECT * FROM Accident WHERE DriverID=? ORDER BY Date DESC";
$stmt = $con->prepare($query);

$stmt->bindParam(1, $id);
$stmt->execute();
 
// this is how to get number of rows returned
$num = $stmt->rowCount();
 
// link to create record form
//echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New User</a>";

echo  "<div class='row'>";
        echo "<div class='col-sm-12'>";
        echo "<div class='box'>";
        echo   "<div class='box-header'>";
            echo  "<h4 class='box-title' style='text-align:center;'>Accidents History ($num) </h3>";
           echo "</div>";
           //s echo "<!-- /.box-header -->";
            echo "<div class='box-body'>";
              //echo "<table id='example1' class='table table-bordered table-striped'>";
              echo "<table class='table table-bordered table-striped'>";
 
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

        
 
 
    //creating our table heading
    echo "<thead>";
    echo "<tr>";
        
        echo "<th>Accident Type</th>";
        echo "<th>Date</th>";
        echo "<th>Time</th>";
       // echo "<th>Description</th>";
        echo "<th>Weather Conditions</th>";
        echo "<th>Severity</th>";
        echo "<th>Light Conditions</th>";
       
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
    //extract($row);

  $accidentID=$row['AccidentID'];
  $accidenttype=$row['Accident_Type'];
  $accidentdate=$row['Date'];
  $accidenttime=$row['Time'];
  $weatherconditions=$row['Weather_Conditions'];
  $severity=$row['Severity'];
  $lightconditions=$row['Light_Conditions'];
  
  
    // creating new table row per record
    echo "<tr>";
        
        
        echo "<td>$accidenttype</td>";
        echo "<td><span class='badge bg-blue'>$accidentdate</span></td>";
        echo "<td><span class='badge bg-red'>$accidenttime</span></td>";
        echo "<td>$weatherconditions</td>";
        //echo "<td><span class='badge bg-green'>$actionTaken</span></td>";
        echo "<td>$severity</td>";
        echo "<td>$lightconditions</td>";





              

         //echo "<td>";
         ?>
           <td> 
          <!-- <td><a href='#out<?php $offenceID;?>' data-toggle='modal' aria-hidden='true'>-->
          <button  class='btn btn-info m-r-1em  view_accident' id="<?php echo $accidentID;?>">View</button>
          
          </td>
        <?php

            extract($row);
            
    echo "</tr>";


              
 }
// end table
echo "</table>";
     

 
// if no records found
}else{
    echo "<div class='alert alert-success'>Driver's Accident Record is Clean! Hurray!.</div>";
}
?>


</div>


</div>




    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

</div>

<script src="bower_components/jquery/dist/jquery.min.js"></script>

  <script>
    $(document).ready(function(){  
      $('.view_data').click(function(){  
           var offence_id = $(this).attr("id");  
           $.ajax({  
                url:"fetchoffence.php",  
                method:"post",  
                data:{offence_id:offence_id},  
                success:function(data){  
                     $('#offence_detail').html(data);  
                     $('#dataModal').modal("show");  
                }  
           });  
      });  
 });  
  </script>

<script>
    $(document).ready(function(){  
      $('.view_accident').click(function(){  
           var accident_id = $(this).attr("id");  
           $.ajax({  
                url:"fetchaccident.php",  
                method:"post",  
                data:{accident_id:accident_id},  
                success:function(data){  
                     $('#accident_detail').html(data);  
                     $('#dataModalAccident').modal("show");  
                }  
           });  
      });  
 });  
  </script>


<div class="modal fade" id="dataModal">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" >Offence Details</h4>
              </div>
              <div class="modal-body" id="offence_detail">

                
               

                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

       <div class="modal fade" id="dataModalAccident">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" >Accident Details</h4>
              </div>
              <div class="modal-body" id="accident_detail">

                
               

                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
                
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->



<?php include 'footer.php';?>