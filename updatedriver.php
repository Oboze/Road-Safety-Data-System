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
        Update Driver Details
        <small>Edits</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="driverinfo.php"></i> Driver Listing</a></li>
        <li class="active">Update Driver</li>
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
              <h3 class="box-title">Change Driver Information as Appropriate</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

        <?php
			// get passed parameter value, in this case, the record ID
			// isset() is a PHP function used to verify if a value is there or not
			$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
			 
			//include database connection
			include 'config.php';
			 
			// read current record's data
			try {
			    // prepare select query
			    $query = "SELECT DriverID, Firstname, Lastname, Middlename, DOB, Sex, Address, National_ID, PassportNo FROM Driver WHERE DriverID = ? LIMIT 0,1";
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
			    $gender=$row['Sex'];
			    $address=$row['Address'];
			    $nationalid=$row['National_ID'];
			    $passport=$row['PassportNo'];
			}
			 
			// show error
			catch(PDOException $exception){
			    die('ERROR: ' . $exception->getMessage());
			}
			?>

			<?php
 
						// check if form was submitted
						if($_POST){
						     
						    try{
						     
						        // write update query
						        // in this case, it seemed like we have so many fields to pass and 
						        // it is better to label them and not use question marks
						        $query = "UPDATE Driver 
						                    SET Firstname=:firstname, Lastname=:lastname, Middlename=:middlename, DOB=:dob, Sex=:sex, Address=:address, National_ID=:nationalid, PassportNO=:passport 
						                    WHERE DriverID = :id";
						 
						        // prepare query for excecution
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
						        $stmt->bindParam(':lastname',$lastname);
						        $stmt->bindParam(':middlename', $middlename);
						        $stmt->bindParam(':dob', $dob);
						        $stmt->bindParam(':sex',$gender);
						        $stmt->bindParam(':address',$address);
						        $stmt->bindParam(':nationalid',$nationalid);
						        $stmt->bindParam(':passport',$passport);
						        $stmt->bindParam(':id', $id);
						         
						        // Execute the query
						        if($stmt->execute()){
						            echo "<div class='alert alert-success'>Record was updated.</div>";
						        }else{
						            echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
						        }
						         
						    }
						     
						    // show errors
						    catch(PDOException $exception){
						        die('ERROR: ' . $exception->getMessage());
						    }
						}
						?>

			<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" enctype="multipart/form-data">
              <div class="box-body">
                <div class="form-group">
                  <label for="firstname" class="col-sm-2 control-label" >First Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" pattern="^[A-Za-z]+$" title="Only a single name is allowed. Also name cannot include a number" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last Name" value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" pattern="^[A-Za-z]+$" title="Only a single name is allowed. Also name cannot include a number" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="middlename" class="col-sm-2 control-label">Middle Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="middlename" name="middlename" value="<?php echo htmlspecialchars($middlename, ENT_QUOTES);  ?>" placeholder="Middle Name" pattern="^[A-Za-z]+$" title="Only a single name is allowed. Also name cannot include a number" required="">
                  </div>
                </div>

                <div class="form-group">
                <label class="col-sm-2 control-label">Date of Birth</label>

                <div class="col-sm-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker" name="dob" value="<?php echo htmlspecialchars($dob, ENT_QUOTES);  ?>">
                  </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Gender</label>

                <div class="col-sm-10">
                  <select class="form-control" style="width: 100%;" name="gender" value="<?php echo htmlspecialchars($gender, ENT_QUOTES);  ?>">
                  <option selected=""> <?php echo htmlspecialchars($gender, ENT_QUOTES);  ?></option>
                  <option >Male</option>
                  <option>Female</option>
                  
                </select>

                </div>
                </div>

                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Address</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address, ENT_QUOTES);  ?>" placeholder="Address">
                  </div>
                </div>

                <div class="form-group">
                  <label for="nationalid" class="col-sm-2 control-label">National ID Number</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="nationalid" name="nationalid" value="<?php echo htmlspecialchars($nationalid, ENT_QUOTES);  ?>" placeholder="National ID Number">
                  </div>
                </div>

                <div class="form-group">
                  <label for="passport" class="col-sm-2 control-label">Driving License Number</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="passport" name="passport" value="<?php echo htmlspecialchars($passport, ENT_QUOTES);  ?>" placeholder="Driving License Number">
                  </div>
                </div>

               <!-- <div class="form-group">
                  <label for="image" class="col-sm-2 control-label">Image</label>

                  <div class="col-sm-10">
                    <input type="file" id="image" name="image">
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
          </div>



              <div class="box-footer">
                <!--<button type="submit" class="btn btn-default">Cancel</button>-->
                <a href="driverinfo.php" class="btn btn-success pull-left"> Back to Driver Listing </a>
                <button type="submit" class="btn btn-info pull-right">Update Driver</button>
              </div>
              <!-- /.box-footer -->
            </form>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php include 'footer.php'?>