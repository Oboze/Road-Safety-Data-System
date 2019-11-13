<?php
include 'config.php';

$accidentid=$_POST["accident_id"];

if(isset($accidentid)){
	
	/*$query = "SELECT * FROM Offence WHERE OffenseID = ?";  

	$stmt = $con->prepare( $query );
 
    // this is the first question mark
    $stmt->bindParam(1, $offenceid);

    // execute our query
    $stmt->execute();*/


    $queryaccident = "SELECT * FROM Accident WHERE AccidentID = ?";

    $stmtaccident = $con->prepare($queryaccident);
 
    // this is the first question mark
    $stmtaccident->bindParam(1, $accidentid);

    $stmtaccident->execute();

   
       while ($rowaccident = $stmtaccident->fetch(PDO::FETCH_ASSOC)){
   			$accidenttype=$rowaccident['Accident_Type'];
        $accidentdate=$rowaccident['Date'];
        $accidenttime=$rowaccident['Time'];
        $weather=$rowaccident['Weather_Conditions'];
        $severity=$rowaccident['Severity'];
        $lightconditions=$rowaccident['Light_Conditions'];
        $alcohol_suspected=$rowaccident['Alcohol_Suspected'];


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

    
   }
             
   



?>