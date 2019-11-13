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
           // echo  "<h3 class='box-title'>Drivers </h3><a href='#' data-toggle='modal' class='pull-right btn  btn-danger' data-target='#add_data_Modal'> Add Driver </a>";
            echo  "<h3 class='box-title'>Drivers </h3><a href='driver.php' class='pull-right btn  btn-danger' > Add Driver </a>";
           echo "</div>";
            echo "<!-- /.box-header -->";
            echo "<div class='box-body'>";
              echo "<table id='example1' class='table table-bordered table-striped'>";
              //echo "<table  class='table table-bordered table-striped'>";
 
    //creating our table heading
    echo "<thead>";
    echo "<tr>";
        echo "<th>Driver Id </th>"; 
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
        echo "<td>{$DriverID}</td>";
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
            //echo "<a href='#' onclick='delete_user({$DriverID});'  class='btn btn-danger disabled'>Delete</a>";
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


  <!-- modals here -->

<div id="add_data_Modal" class="modal fade">
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
   <!-- <h4 class="modal-title">Add Driver Information</h4>-->
   </div>
   <div class="modal-body">

      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Driver Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data" id="driverform">
              <div class="box-body">
                <div class="form-group">
                  <label for="firstname" class="col-sm-2 control-label">First Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required="" pattern="^[A-Za-z]+$" title="Only a single name is allowed. Also name cannot include a number" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name"   required="" pattern="^[A-Za-z]+$" title="Only a single name is allowed. Also name cannot include a number">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middlename" class="col-sm-2 control-label">Middle Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name"  pattern="^[A-Za-z]+$" title="Only a single name is allowed. Also name cannot include a number"  required="">
                  </div>
                </div>

                <div class="form-group">
                <label class="col-sm-2 control-label">Date of Birth</label>

                <div class="col-sm-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" name="dob">
                  </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Gender</label>

                <div class="col-sm-10">
                  <select class="form-control" style="width: 100%;" name="gender">
                  <option selected="selected">Male</option>
                  <option>Female</option>
                  
                </select>

                </div>
                </div>

                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Address</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" placeholder="Address">
                  </div>
                </div>

                <div class="form-group">
                  <label for="nationalid" class="col-sm-2 control-label">National ID Number</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="nationalid" name="nationalid" placeholder="National ID Number" onBlur="checkIdAvailability()"><span id="id-availability-status"></span>

                  </div>
                </div>

                <div class="form-group">
                  <label for="passport" class="col-sm-2 control-label">Driving License Number</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="license" name="license" placeholder="Driving License Number" onBlur="checkLicenseAvailability()">
                    <span id="username-availability-status"></span>
                  </div>
                </div>

                <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Image</label>

                  <div class="col-sm-10">
                    <input type="file" id="image" name="image" required="">
                  </div>
                </div>
                <!-- /.input group -->
              
              <!--<div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"> Remember me
                      </label>
                    </div>
                  </div>
                </div>
              </div>-->
              

              
              
              <!-- /.box-body -->
              <div class="box-footer">
                <a type="button" href="driverinfo.php" class="btn btn-default pull-left">Back to Driver Listing</a>
                <button type="submit" class="btn btn-info pull-right" id="add">Add Driver</button>
              </div>
              <!-- /.box-footer -->
            </form>
      </div>
    </div>
  </div>

    
   </div>
   <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
   </div>
  </div>
 </div>
</div>
<!--modals above-->

<script src="bower_components/jquery/dist/jquery.min.js"></script>


<!--scripts here -->

<script>
function checkIdAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'nationalid='+$("#nationalid").val(),
type: "POST",
success:function(data){
$("#id-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

function checkLicenseAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'license='+$("#license").val(),
type: "POST",
success:function(data){
$("#username-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>

<script>  
$(document).ready(function(){
 $('#driverform').on("submit", function(event){  
  /*event.preventDefault();  
  if($('#name').val() == "")  
  {  
   alert("Name is required");  
  }  
  else if($('#address').val() == '')  
  {  
   alert("Address is required");  
  }  
  else if($('#designation').val() == '')
  {  
   alert("Designation is required");  
  }
   
  else  
  {  */
   $.ajax({  
    url:"insertdriver.php",  
    method:"POST",  
    data:$('#driverform').serialize(),  
    beforeSend:function(){  
     $('#add').val("Adding Driver");  
    },  
    success:function(data){  
     $('#driverform')[0].reset();  
     $('#add_data_Modal').modal('hide');  
     $('#example1').html(data);  
    }  
   });  
   })
 });



 
 </script>


<?php include 'footer.php'?>