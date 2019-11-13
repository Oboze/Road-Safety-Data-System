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
        Driver
        <small>Driver Information</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home </a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content container-fluid">

      <!--------------------------
        | Your Page Content Here |
        -------------------------->
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Driver Details</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

            <?php
if($_POST && isset($_POST['firstname'] )){
 
    // include database connection
    include 'config.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO Driver SET Firstname=:firstname, Lastname=:lastname, Middlename=:middlename, DOB=:dob, Sex=:sex, Address=:address, National_ID=:nationalid, Training=:training, LicenseNo=:license, image=:image";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
 
        // posted values
        $firstname=htmlspecialchars(strip_tags($_POST['firstname']));
        $lastname=htmlspecialchars(strip_tags($_POST['lastname']));
        $middlename=htmlspecialchars(strip_tags($_POST['middlename']));
        $dob=htmlspecialchars(strip_tags($_POST['dob']));
        $gender=htmlspecialchars(strip_tags($_POST['gender']));
        $address=htmlspecialchars(strip_tags($_POST['address']));
        $nationalid=htmlspecialchars(strip_tags($_POST['nationalid']));
        $training=htmlspecialchars(strip_tags($_POST['training']));
        $license=htmlspecialchars(strip_tags($_POST['license']));

        // new 'image' field
        $image=!empty($_FILES["image"]["name"])
        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
        : "";
        $image=htmlspecialchars(strip_tags($image));

 
        // bind the parameters
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':sex', $gender);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':nationalid',$nationalid);
        $stmt->bindParam(':training',$training);
        $stmt->bindParam(':license',$license);
        $stmt->bindParam(':image', $image);
        // specify when this record was inserted to the database
        
         
        // Execute the query
        if($stmt->execute()){
           // echo "<div class='alert alert-success'>Record was saved.</div>";


            echo "<div class=\"alert alert-success alert-dismissible\">";
              echo  "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "<h4><i class=\"icon fa fa-check\"></i> Success!</h4>";
                echo "Record was saved. <br>";
                echo "You can still proceed to add another Driver below.<i class=\"icon fa fa-smile-o\"></i> If not <a href='driverinfo.php'><h6>Click Here</h6></a> to go back to Driver Listing";
              echo "</div>";

            // now, if image is not empty, try to upload the image
        if($image){
         
            // sha1_file() function is used to make a unique file name
            $target_directory = "uploads/";
            $target_file = $target_directory . $image;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
         
            // error message is empty
            $file_upload_error_messages="";
         
        }

        // make sure that file is a real image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check!==false){
            // submitted file is an image
        }else{
            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
        }
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }

        // make sure file does not exist
        /*if(file_exists($target_file)){
            $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
        }*/
        // make sure submitted file is not too large, can't be larger than 1 MB
        if($_FILES['image']['size'] > (1024000)){
            $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
        }

        // make sure the 'uploads' folder exists
        // if not, create it
        if(!is_dir($target_directory)){
            mkdir($target_directory, 0777, true);
        }

        // if $file_upload_error_messages is still empty
        if(empty($file_upload_error_messages)){
            // it means there are no errors, so try to upload the file
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                // it means photo was uploaded
            }else{
            /*    echo "<div class='alert alert-danger'>";
                    echo "<div>Unable to upload photo.</div>";
                    echo "<div>Update the record to upload photo.</div>";
                echo "</div>";*/
            }
        }
         
        // if $file_upload_error_messages is NOT empty
        else{
            // it means there are some errors, so show them to user
         /*   echo "<div class='alert alert-danger'>";
                echo "<div>{$file_upload_error_messages}</div>";
                echo "<div>Update the record to upload photo.</div>";
            echo "</div>";*/
        }
         
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

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
                  <label class="col-sm-2 control-label">Driver Training</label>

                <div class="col-sm-10">
                  <select class="form-control" style="width: 100%;" name="training">
                  <option selected="selected">AA Driving School</option>
                  <option>Rocky Driving School</option>
                  <option>Heltz Driving School</option>
                  <option>Petanns Driving School</option>
                  <option>Senior Driving School</option>
                  <option>Wings Driving School</option>
                  <option>Imperial Driving School</option>
                  <option>Sony Driving School</option>
                  <option>Iqra Driving School</option>
                  <option>Glory Driving School</option>
                  <option>Private</option>
                  
                </select>

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
                <button type="submit" class="btn btn-info pull-right">Add Driver</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  
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

  <?php include 'footer.php'?>