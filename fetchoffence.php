<?php 
	/*if(isset($_POST["driver_id"]))  
 {  
      $output = '';  
      $connect = mysqli_connect("localhost", "root", "", "road_safe");  
      $query = "SELECT * FROM Offence WHERE OffenseID = '".$_POST["driver_id"]."'";  
      
      $result = mysqli_query($connect, $query);  
      $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">';  
      while($row = mysqli_fetch_array($result))  
      {  
           $output .= '  
                <tr>  
                     <td width="30%"><label>Offense Type</label></td>  
                     <td width="70%">'.$row["Offence_Type"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Date</label></td>  
                     <td width="70%"><span class="badge bg-blue">'.$row["Date"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Time</label></td>  
                     <td width="70%"><span class="badge bg-red">'.$row["Time"].'</span></td>  
                </tr>  
                  
                <tr>  
                     <td width="30%"><label>Action Taken</label></td>  
                     <td width="70%"><span class="badge bg-green">'.$row["Action_Taken"].'</span></td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Penalty Score</label></td>  
                     <td width="70%">'.$row["Risk_Score"].' </td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Description</label></td>  
                     <td width="70%">'.$row["Description"].'</td>  
                </tr>
                ';  
      }  
      $output .= "</table></div>";  
      echo $output;  
 } */ 

?>

<?php
include 'config.php';

$offenceid=$_POST["offence_id"];

if(isset($offenceid)){
	$output = '';
	$query = "SELECT * FROM Offence WHERE OffenseID = ?";  

	$stmt = $con->prepare( $query );
 
    // this is the first question mark
    $stmt->bindParam(1, $offenceid);

    // execute our query
    $stmt->execute();


    $queryaccident = "SELECT * FROM Accident WHERE OffenceID = ?";

    $stmtaccident = $con->prepare($queryaccident);
 
    // this is the first question mark
    $stmtaccident->bindParam(1, $offenceid);

    $stmtaccident->execute();

    $output .= '  
      <div class="table-responsive">  
           <table class="table table-bordered">'; 
 
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    	$output .= '  
                <tr>  
                     <td width="30%"><label>Offense Type</label></td>  
                     <td width="70%">'.$row["Offence_Type"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Date</label></td>  
                     <td width="70%"><span class="badge bg-blue">'.$row["Date"].'</td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Time</label></td>  
                     <td width="70%"><span class="badge bg-red">'.$row["Time"].'</span></td>  
                </tr>  
                  
                <tr>  
                     <td width="30%"><label>Action Taken</label></td>  
                     <td width="70%"><span class="badge bg-green">'.$row["Action_Taken"].'</span></td>  
                </tr> 
                <tr>  
                     <td width="30%"><label>Penalty Score</label></td>  
                     <td width="70%">'.$row["Risk_Score"].' </td>  
                </tr>  
                <tr>  
                     <td width="30%"><label>Description</label></td>  
                     <td width="70%">'.$row["Description"].'</td>  
                </tr>

                ';  

    

    }

    $output .= "</table></div>";  
      echo $output; 

   $num=$stmtaccident->rowCount();

   if ($num>0){

   	  
     
   	while ($rowaccident = $stmtaccident->fetch(PDO::FETCH_ASSOC)){
   			$accidenttype=$rowaccident['Accident_Type'];
        $accidentdate=$rowaccident['Date'];
        $accidenttime=$rowaccident['Time'];
        $weather=$rowaccident['Weather_Conditions'];
        $severity=$rowaccident['Severity'];
        $lightconditions=$rowaccident['Light_Conditions'];
        $alcohol_suspected=$rowaccident['Alcohol_Suspected'];


   		echo "<strong> This Offence culminated in an accident. See Information Below</strong>";

      echo "<div class='table-responsive'>";  
           echo "<table class='table table-bordered'>"; 

              echo "<tr>";
               echo "<td> Accident Type</td>";
   		  
                echo "<td> $accidenttype </td>";
                echo "<tr>";

                echo "<tr>";
               echo "<td> Accident Date</td>";
        
                echo "<td> $accidentdate </td>";
                echo "<tr>";

                echo "<tr>";
               echo "<td> Accident Time</td>";
        
                echo "<td> $accidenttime </td>";
                echo "<tr>";

                echo "<tr>";
               echo "<td> Weather Conditions</td>";
        
                echo "<td> $weather </td>";
                echo "<tr>";

                echo "<tr>";
               echo "<td> Severity</td>";
        
                echo "<td> $severity </td>";
                echo "<tr>";

                echo "<tr>";
               echo "<td> Light Conditions</td>";
        
                echo "<td> $lightconditions </td>";
                echo "<tr>";

                echo "<tr>";
               echo "<td> Alcohol Use</td>";
        
                echo "<td> $alcohol_suspected </td>";
                echo "<tr>";








                echo "</table>";
                
                 

    

    }// end of while

    
   }else{

  ?>

        <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Alert!</h4>
                This offence did not culminate in an accident!
              </div>
 <?php             
   }//end of if 
   }



?>