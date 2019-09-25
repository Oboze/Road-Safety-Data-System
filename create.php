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

include 'headeradmin.php';?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create New User
        <small>Users</small>
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
              <h3 class="box-title">Fill Form Details Below:</h3>
            </div>
            <!-- /.box-header -->

            <?php
if($_POST){
 
    // include database connection
    include 'config.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO Users SET Firstname=:firstname, Lastname=:lastname, Username=:username, Password=:password, User_role=:userrole";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
 
        // posted values
        $firstname=htmlspecialchars(strip_tags($_POST['firstname']));
        $lastname=htmlspecialchars(strip_tags($_POST['lastname']));
        $username=htmlspecialchars(strip_tags($_POST['username']));
        $password=htmlspecialchars(strip_tags($_POST['password']));
        $userrole=htmlspecialchars(strip_tags($_POST['userrole']));
 
        // bind the parameters
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':userrole', $userrole);
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
            

            <!-- form start -->
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
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
                  <label for="username" class="col-sm-2 control-label">Username</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username " required="">
                  </div>
                </div>

                <div class="form-group">
                  <label for="password" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-5">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="">
                  </div>
                </div>



                

               	<div class="form-group">
                  <label class="col-sm-2 control-label">User Role</label>

                <div class="col-sm-10">
                  <select class="form-control" name="userrole" style="width: 100%;">
                  <option selected="selected">police</option>
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
                <button type="submit" class="btn btn-info pull-right">Add User</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
        </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php include 'footeradmin.php';?>  