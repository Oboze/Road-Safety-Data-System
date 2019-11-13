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
$driverid=$_SESSION['driverid'];
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add Accident 
        <small></small>
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
              <h3 class="box-title">Add New Accident Details</h3>
              <a href="view_driver.php?id=<?php echo $driverid;?>" class="btn btn-success pull-right"> Back to Driver's Profile</a>
            </div>
            <!-- /.box-header -->
            <!-- form start -->


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

        $stmt->execute();

        // get the offence ID of the last record appended to the database
        $lastOffenceID=$con->lastInsertId();


        //query for inserting road details into road table
        $queryroad = "INSERT INTO Road SET Road_Location=:roadlocation, Road_Name=:roadname, Classification=:classification, Road_Condition=:roadcondition, Surface_Type=:surfacetype, Road_Geometry=:roadgeometry, Traffic_Movement=:trafficmovement";

        // prepare query for execution 

        $stmtroad=$con->prepare($queryroad);

        $roadlocation=htmlspecialchars(strip_tags($_POST['roadlocation']));
        $roadname=htmlspecialchars(strip_tags($_POST['roadname']));
        $roadclassification=htmlspecialchars(strip_tags($_POST['roadclassification']));
        $roadcondition=htmlspecialchars(strip_tags($_POST['roadcondition']));
        $surfacetype=htmlspecialchars(strip_tags($_POST['surfacetype']));
        $roadgeometry=htmlspecialchars(strip_tags($_POST['roadgeometry']));
        $trafficmovement=htmlspecialchars(strip_tags($_POST['trafficmovement']));

        //bind the parameters

        $stmtroad->bindParam(':roadlocation',$roadlocation);
        $stmtroad->bindParam(':roadname',$roadname);
        $stmtroad->bindParam(':classification',$roadclassification);
        $stmtroad->bindParam(':roadcondition',$roadcondition);
        $stmtroad->bindParam(':surfacetype',$surfacetype);
        $stmtroad->bindParam(':roadgeometry',$roadgeometry);
        $stmtroad->bindParam(':trafficmovement',$trafficmovement);

        $stmtroad->execute();

        $lastRoadID=$con->lastInsertId();

        
        // query for inserting into acccident table
        $queryaccident = "INSERT INTO Accident SET Accident_Type=:type, Date=:dateaccident, Time=:timeaccident, Weather_Conditions=:weather, Severity=:severity, Light_Conditions=:light, Alcohol_Suspected=:alcohol, Drug_Use_Suspected=:drug, DriverID=:driverid, RoadID=:roadid, OffenceID=:offenceid";
 		
        // prepare query for execution
        $stmtaccident = $con->prepare($queryaccident);
 
        $accidenttype=$_POST['accidenttype'];
        $accidentdate=$_POST['accidentdate'];
        $accidenttime=$_POST['accidenttime'];
        $weather=$_POST['weather'];
        $severity=$_POST['severity'];
        $light=$_POST['light'];
        $alcohol=$_POST['alcohol'];
        $drug=$_POST['drug'];


       	$stmtaccident->bindParam(':type',$accidenttype);
       	$stmtaccident->bindParam(':dateaccident',$accidentdate);
       	$stmtaccident->bindParam(':timeaccident',$accidenttime);
       	$stmtaccident->bindParam(':weather',$weather);
       	$stmtaccident->bindParam(':severity',$severity);
       	$stmtaccident->bindParam(':light',$light);
       	$stmtaccident->bindParam(':alcohol',$alcohol);
       	$stmtaccident->bindParam(':drug',$drug);
       	$stmtaccident->bindParam(':driverid',$driverid);
       	$stmtaccident->bindParam(':roadid',$lastRoadID);
       	$stmtaccident->bindParam(':offenceid',$lastOffenceID);


         
        // Execute the query
        if($stmtaccident->execute()){
            echo "<div class='alert alert-success'>Record was saved.</div>";
            
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
            //echo $driverid;
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
              	<!--Offence Details-->

              	
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
                  
                 
              </select>

                </div>
                </div>





              	<!--Offence Details-->
                <div class="form-group">
                  <label for="accidenttype" class="col-sm-2 control-label">Accident Type</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="accidenttype">
                  <option selected="selected">Head On</option>
                  <option>Hit Pedestrian</option>
                  <option>Hit From Rear</option>
                  <option>Hit From Side</option>
                  <option>Side Swipe</option>
                  <option>Skidding</option>
                  <option>Ran off road crash</option>
                  <option>Overtuning</option>
                  <option>Overtuning-no collision</option>
                  <option>Hit Object in Road</option>
                  <option>Hit Object off Road</option>
                  <option>Hit Parked Vehicle</option>

                  
                </select>
                  </div>
                </div>

                <div class="form-group">
                <label class="col-sm-2 control-label">Accident Date</label>

                <div class="col-sm-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="accidentdate" value="<?php echo date('Y-m-d');?>" readonly>
                  </div>
                  </div>
                </div>


                <div class="bootstrap-timepicker">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Accident Time</label>
                  <div class="col-sm-10">
                  <div class="input-group ">
                  	<div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker" name="accidenttime">

                    
                </div>
                  </div>
                  <!-- /.input group -->
                </div>
                <!-- /.form group -->
              </div>


                <div class="form-group">
                  <label for="lastname" class="col-sm-2 control-label">Weather Conditions</label>

                  <div class="col-sm-10">
                  	<select class="form-control" style="width: 100%;" name="weather">
                  <option selected="selected">Fine</option>
                  <option>Misty</option>
                  <option>Cloudy</option>
                  <option>Light Rain</option>
                  <option>Heavy Rain</option>
                  <option>Flooding</option>
                  <option>Hail/Sleet</option>
                  <option>Smoke/Dust</option>
                  <option>Strong Winds</option>
                  <option>Very Cold</option>
                  <option>Very Hot</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="nationalid" class="col-sm-2 control-label">Severity</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="severity">
                  <option selected="selected">Property Damage</option>
                  <option>Personal Injury</option>
              </select>

                  </div>
                </div>


                <div class="form-group">
                  <label for="middlename" class="col-sm-2 control-label">Light Conditions</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="light">
                  <option selected="selected">Daylight</option>
                  <option>Twilight</option>
                  <option>Darkness With Street Lights On</option>
                  <option>Darkness With No Street Lights</option>
                  <option>Darkenss With Poor Street Lights</option>
              </select>
                  </div>
                </div>

                

                <div class="form-group">
                  <label class="col-sm-2 control-label">Alcohol Suspected</label>

                <div class="col-sm-10">
                  <select class="form-control" style="width: 100%;" name="alcohol">
                  <option selected="selected">No</option>
                  <option>Yes</option>
                  
                </select>

                </div>
                </div>

                <div class="form-group">
                  <label for="address" class="col-sm-2 control-label">Drug Use Suspected</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="drug">
                  <option selected="selected">No</option>
                  <option>Yes</option>
              </select>
                </div>
                </div>



                

                

              <!-- <div class="form-group">
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

              <!-- Add Accident Information-->

              <div class="form-group">
                  <label for="accidenttype" class="col-sm-2 control-label">Road Location</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="roadlocation" id="roadlocation">

                  <option selected="selected" value="locationnone">Select a Location</option>
                  <option> Kileleshwa </option>
                  <option>Kilimani</option>
                  <option >Lavington</option>
                  <option >Westlands</option>
                  <option>Nairobi West</option>
                  <option>Nairobi South</option>
                  

                  
                </select>
                  </div>
                </div>


              <div class="form-group">
                  <label for="accidenttype" class="col-sm-2 control-label">Road Name</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="roadname" id="roadname">
                 <!-- <option selected="selected">Mbooni Road</option>
                  <option>Mombasa Road</option>
                  <option>Langata Road</option>
                  <option>Dennis Pritt Road</option>
                  <option>Jacaranda Road</option>
                  <option>Tigoni Road</option>-->
                  

                  
                </select>
                  </div>
                </div>


                <div class="form-group">
                  <label for="roadclassification" class="col-sm-2 control-label">Road Classification</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="roadclassification">
                  <option selected="selected">Primary Road</option>
                  <option>Secondary Road</option>
                  <option>Minor Road</option>
                  <option>Special Purpose Road</option>
                  
                  

                  
                </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="roadcondition" class="col-sm-2 control-label">Road Condition</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="roadcondition">
                  <option selected="selected">Good</option>
                  <option>Poor</option>
                  <option>Muddy</option>
                  <option>Slippery Surface</option>
                  <option>Pot Holed</option>
                  <option>Oily</option>
                  <option>Dry</option>
                  <option>Wet</option>
                  </select>
                  </div>
                </div>


                <div class="form-group">
                  <label for="surfacetype" class="col-sm-2 control-label">Surface Type</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="surfacetype">
                  <option selected="selected">Tarred (Bitumen)</option>
                  <option>Concrete</option>
                  <option>Murram</option>
                 </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="roadgeometry" class="col-sm-2 control-label">Road Geometry</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="roadgeometry">
                  <option selected="selected">Straight</option>
                  <option>Slight Curve</option>
                  <option>Sharp Bend</option>
                  </select>
                  </div>
                </div>

                <div class="form-group">
                  <label for="trafficmovement" class="col-sm-2 control-label">Traffic Movement</label>

                  <div class="col-sm-10">
                    <select class="form-control" style="width: 100%;" name="trafficmovement">
                  <option selected="selected">One Way</option>
                  <option>Two Way</option>
                  </select>
                  </div>
                </div>
              

              
              
              <!-- /.box-body -->
              <div class="box-footer">
                <a type="button" href="driverinfo.php" class="btn btn-default pull-left">Back to Driver Listing</a>
                <button type="submit" class="btn btn-info pull-right">Add Accident</button>
              </div>
              <!-- /.box-footer -->
            </form>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <script src="bower_components/jquery/dist/jquery.min.js"></script>

  <script>
  

    $(document).ready(function () {
    $("#roadlocation").change(function () {
        var val = $(this).val();
        if (val == "Kileleshwa") {
            $("#roadname").html("<option>Mbooni Road</option><option>Mazeras Road</option>");
        } else if (val == "Kilimani") {
            $("#roadname").html("<option>Dennis Pritt</option><option>Lenana Road</option>");
        } else if (val == "Lavington") {
            $("#roadname").html("<option>Muthangari Road</option><option>River Side Drive</option>");
        } else if (val == "Westlands") {
            $("#roadname").html("<option>Rhapta Road</option><option>Peponi Road</option>");
        } else if (val =="Nairobi West"){
        	$("#roadname").html("<option>Ole Shapara Road</option><option>Akiba Road</option>");
        }else if (val =="Nairobi South"){
        	$("#roadname").html("<option>Mombasa Road</option><option>Kamburu Road</option>");
        }
    });
});


 </script>



<?php include 'footer.php'?>