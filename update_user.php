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
        Edit User Information
       <!-- <small>Optional description</small>-->
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
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Update User Info Below</h3>
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
			    $query = "SELECT UserID, Firstname, Lastname, Username, Password, User_role FROM Users WHERE UserID = ? LIMIT 0,1";
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
			    $password=$row['Password'];
			    $userrole=$row['User_role'];
			   
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
						        $query = "UPDATE Users 
						                    SET Firstname=:firstname, Lastname=:lastname, Username=:username, Password=:password, User_role=:userrole
						                    WHERE UserID = :id";
						 
						        // prepare query for excecution
						        $stmt = $con->prepare($query);
						 
						        // posted values
						        $firstname=htmlspecialchars(strip_tags($_POST['firstname']));
						        $lastname=htmlspecialchars(strip_tags($_POST['lastname']));
						        $username=htmlspecialchars(strip_tags($_POST['username']));
						        $password=htmlspecialchars(strip_tags($_POST['password']));
						        $userrole=htmlspecialchars(strip_tags($_POST['userrole']));
						        
						 
						        // bind the parameters
						        $stmt->bindParam(':firstname', $firstname);
						        $stmt->bindParam(':lastname',$lastname);
						        $stmt->bindParam(':username',$username);
						        $stmt->bindParam(':password',$password);
						        $stmt->bindParam(':userrole',$userrole);
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


						<!-- form start -->
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
              <div class="box-body">
                <div class="form-group">
                  <label for="firstname" class="col-sm-2 control-label">First Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname, ENT_QUOTES);  ?>" placeholder="First Name" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="lastname" class="col-sm-2 control-label">Last Name</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname, ENT_QUOTES);  ?>" placeholder="Last Name" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label for="username" class="col-sm-2 control-label">Username</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username, ENT_QUOTES);  ?>" placeholder="Username " required="" >
                  </div>
                </div>

                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-5">
                    <input type="password" class="form-control" id="password" value="<?php echo htmlspecialchars($password, ENT_QUOTES);  ?>" name="password" placeholder="Password" required="">
                  </div>
                </div>



                

               	<div class="form-group">
                  <label class="col-sm-2 control-label">User Role</label>

                <div class="col-sm-10">
                  <select class="form-control" name="userrole" style="width: 100%;">
                  <option selected="selected" value="<?php echo htmlspecialchars($userrole, ENT_QUOTES);  ?>"><?php echo htmlspecialchars($userrole, ENT_QUOTES);  ?></option>
                  <option> police</option>
                  <option>admin</option>
                 <!-- <option>NTSA</option>-->


                  
                </select>

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
                <a href="admin.php"  class="btn btn-default pull-left">Back to User List</a>
                <button type="submit" class="btn btn-info pull-right">Update User</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <?php include 'footeradmin.php' ?>