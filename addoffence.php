<?php

/*session_start();
$id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

echo $id;*/


 
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

//echo $_SESSION['driverid'];
$driverid=$_SESSION['driverid'];
//echo $driverid;
include 'header.php' ?>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Create New Offence Record
        <small>For Driver</small>
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
              <a href="view_driver.php?id=<?php echo $driverid;?>" class="btn btn-success pull-right"> Back To Driver Profile</a>
            </div>
            <!-- /.box-header -->

            <?php
if($_POST){
 
    // include database connection
    include 'config.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO Offence SET Offence_Type=:offensetype, Date=:dateoccured, Time=:timeoccured, Description=:description, Risk_Score=:riskscore, Action_Taken=:actiontaken, DriverID=:driverid";
 
        // prepare query for execution
        $stmt = $con->prepare($query);
 
        // posted values
        //$offensename=htmlspecialchars(strip_tags($_POST['offensename']));
        $offensetype=htmlspecialchars(strip_tags($_POST['offensetype']));
        $date=htmlspecialchars(strip_tags($_POST['offensedate']));
        $time=htmlspecialchars(strip_tags($_POST['offensetime']));
        $description=htmlspecialchars(strip_tags($_POST['offensedesc']));
        $actiontaken=htmlspecialchars(strip_tags($_POST['actiontaken']));
        //$driverid=$_SESSION['driverid'];


        if ($offensetype=="Learner Failing to exhibit L Plates on the front and rear"){
        	$score=1;
        }elseif($offensetype=="Failing to carry and produce a driving license on demand"){
        	$score=1;
        }elseif($offensetype=="Failure by owner of vehicle to have seat belts in motor vehicle"){
        	$score=2;

        }elseif($offensetype=="Failure to wear a seat belt while the motor vehicle is in motion"){
        	$score=2;

        }elseif($offensetype=="Failure of a vehicle to carry reflective/warning signs"){
        	$score=2;
        }elseif($offensetype=="Driving using a mobile while vehicle is in motion"){
        	$score=2;
        }elseif($offensetype=="Person who while not being designated driver of a PSV drives the vehicle"){
        	$score=3;
        }elseif($offensetype=="Driver of Bus or Matatu picking and setting down passengers in a non-designated place"){
        	$score=2;
        }elseif($offensetype=="Travelling with part of the body outside moving vehicle"){
        	$score=1;
        }
        elseif($offensetype=="Motorcycle rider riding without protective gear"){
        	$score=2;
        }
        elseif($offensetype=="Driving without identification plates affixed or plates not fixed in the prescribed manner"){
        	$score=1;
        }
        elseif($offensetype=="Driving without a valid inspection certificate"){
        	$score=3;
        }
        elseif($offensetype=="Driving without a valid driving license endorsement in respect of the class of the vehicle"){
        	$score=3;
        }
        elseif($offensetype=="Failure to renew license"){
        	$score=2;
        }
        elseif($offensetype=="The driver of a PSV driver who lets an unauthorized person drive"){
        	$score=4;
        }
        elseif($offensetype=="Driving a PSV while unqualified"){
        	$score=4;
        }
        elseif($offensetype=="Exceeding speed limit prescribed for the class of vehicle by 1-5 kph"){
        	$score=2;
        }
        elseif($offensetype=="Exceeding speed limit prescribed for the class of vehicle by 6-10kph"){
        	$score=3;
        }
        elseif($offensetype=="Exceeding speed limit prescribed for the class of vehicle by 11-15kph"){
        	$score=4;
        }
        elseif($offensetype=="Exceeding speed limit prescribed for the class of vehicle by 16-20kph"){
        	$score=5;
        }
        elseif($offensetype=="Exceeding speed limit prescribed for the class of vehicle by 21 kph and over"){
        	$score=6;
        }
        elseif($offensetype=="Driving on or through pavement or a pedestrian walkway"){
        	$score=3;
        }
        elseif($offensetype=="Failure of a driver to stop when required to do so by a police officer in uniform"){
        	$score=3;
        }
        elseif($offensetype=="Failure of a driver to conform to the indications given by any traffic sign"){
        	$score=3;
        }
        elseif($offensetype=="Driver of a motorcycle carrying more than one pillion passenger"){
        	$score=4;
        }
        
        elseif($offensetype=="Driving while intoxicated and above allowable alcohol intake limit"){
        	$score=7;
        }
        elseif($offensetype=="Dangerous overtaking"){
        	$score=5;
        }
        
 
        // bind the parameters
        
        $stmt->bindParam(':offensetype', $offensetype);
        $stmt->bindParam(':dateoccured', $date);
        $stmt->bindParam(':timeoccured', $time);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':riskscore',$score);
        $stmt->bindParam(':actiontaken',$actiontaken);
        $stmt->bindParam(':driverid',$driverid);
        // specify when this record was inserted to the database
        
         
        // Execute the query
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
            
            
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
            echo $driverid;
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
                  <label class="col-sm-2 control-label">Offence Type</label>

                <div class="col-sm-10">
                  <select class="form-control" name="offensetype" style="width: 100%;">
                  <option selected="selected">Learner Failing to exhibit L Plates on the front and rear</option>
                  <option>Failing to carry and produce a driving license on demand</option>
                  <option>Failure by owner of vehicle to have seat belts in motor vehicle </option>
                  <option>Failure to wear a seat belt while the motor vehicle is in motion</option>
                  <option>Failure of a vehicle to carry reflective/warning signs</option>
                  <option>Driving using a mobile while vehicle is in motion</option>
                  <option>Person who while not being designated driver of a PSV drives the vehicle</option>
                  <option>Driver of Bus or Matatu picking and setting down passengers in a non-designated place</option>
                  <option>Travelling with part of the body outside moving vehicle </option>
                  <option>Motorcycle rider riding without protective gear</option>
                  <option>Driving without identification plates affixed or plates not fixed in the prescribed manner</option>
                  <option>Driving without a valid inspection certificate</option>
                  <option>Driving without a valid driving license endorsement in respect of the class of the vehicle</option>
                  <option>Failure to renew license</option>
           
                  <option>The driver of a PSV driver who lets an unauthorized person drive</option>
                  <option>Driving a PSV while unqualified</option>
                  <option>Exceeding speed limit prescribed for the class of vehicle by 1-5 kph</option>
                  <option>Exceeding speed limit prescribed for the class of vehicle by 6-10kph</option>
                  <option>Exceeding speed limit prescribed for the class of vehicle by 11-15kph</option>
                  <option>Exceeding speed limit prescribed for the class of vehicle by 16-20kph</option>
                  <option>Exceeding speed limit prescribed for the class of vehicle by 21 kph and over</option>
                  <option>Driving on or through pavement or a pedestrian walkway</option>
                  <option>Failure of a driver to stop when required to do so by a police officer in uniform</option>
                  <option>Failure of a driver to conform to the indications given by any traffic sign</option>
                  <option>Driver of a motorcycle carrying more than one pillion passenger</option>
                
                  <option>Driving while intoxicated and above allowable alcohol intake limit</option>
                  <option>Dangerous overtaking</option>
                 <!-- <option>NTSA</option>-->
              </select>

                </div>
                </div>


                <div class="form-group">
                <label class="col-sm-2 control-label">Date of Occurence</label>

                <div class="col-sm-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="offensedate" value="<?php echo date('Y-m-d');?>" readonly>
                  </div>
                  </div>
                </div>

                <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Time of Occurence</label>
                  <div class="col-sm-10">
                  <div class="input-group ">
                  	<div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker" name="offensetime">

                    
                </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>


                <div class="form-group">
                  <label for="lastname" class="col-sm-2 control-label">Description</label>

                  <div class="col-sm-10">
                    <textarea class="form-control" rows="3" placeholder="Enter ..." name="offensedesc" required=""></textarea>
                  </div>
                </div>

                
                <div class="form-group">
                  <label class="col-sm-2 control-label">Action Taken</label>

                <div class="col-sm-10">
                  <select class="form-control" name="actiontaken" style="width: 100%;">
                  <option selected="selected">Fined Only</option>
                  <option>Arrested and Fined</option>
                  <option>Arrested and Charged to appear in Court</option>
                  
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
                <a href="driverinfo.php"  class="btn btn-default pull-left">Back to Driver List</a>
                <button type="submit" class="btn btn-info pull-right">Add Offence Record</button>
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
