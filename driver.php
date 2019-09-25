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
        <li><a href="#"><i class="fa fa-dashboard"></i> Home </a></li>
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
if($_POST){
 
    // include database connection
    include 'config.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO Driver SET Firstname=:firstname, Lastname=:lastname, Middlename=:middlename, DOB=:dob, Sex=:sex, Address=:address, National_ID=:nationalid, PassportNo=:passport";
 
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
        $passport=htmlspecialchars(strip_tags($_POST['passport']));

 
        // bind the parameters
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':sex', $gender);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':nationalid',$nationalid);
        $stmt->bindParam(':passport',$passport);
        // specify when this record was inserted to the database
        
         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }
         
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

            <form class="form-horizontal action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"">
              <div class="box-body">
                <div class="form-group">
                  <label for="firstname" class="col-sm-2 control-label">First Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middlename" class="col-sm-2 control-label">Middle Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle Name" required="">
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
                    <input type="text" class="form-control" id="nationalid" name="nationalid" placeholder="National ID Number">
                  </div>
                </div>

                <div class="form-group">
                  <label for="passport" class="col-sm-2 control-label">Passport Number</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="passport" name="passport" placeholder="Passport Number">
                  </div>
                </div>

                <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Image</label>

                  <div class="col-sm-10">
                    <input type="file" id="image" name="driverimage">
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
                <!--<button type="submit" class="btn btn-default">Cancel</button>-->
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

  <?php include 'footer.php'?>