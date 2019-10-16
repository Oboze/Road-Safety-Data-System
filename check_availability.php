<?php
$con = mysqli_connect("localhost","root","","road_safe");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
 }

if(!empty($_POST["nationalid"])) {
$result = mysqli_query($con,"SELECT count(*) FROM Driver WHERE National_ID='" . $_POST["nationalid"] . "'");
$row = mysqli_fetch_row($result);
$email_count = $row[0];
if($email_count>0) echo "<span style='color:red'> This National ID Number Already Exists! Record will not be added to the database</span>";
//else echo "<span style='color:green'> National ID does not Exist.</span>";
}

?>