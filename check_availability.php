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

//Code check user name
if(!empty($_POST["license"])) {
	$result1 = mysqli_query($con,"SELECT count(*) FROM Driver WHERE LicenseNO='" . $_POST["license"] . "'");
	$row1 = mysqli_fetch_row($result1);
	$user_count = $row1[0];
	if($user_count>0) echo "<span style='color:red'> This License Number Already Exists! Record will not be added to the database </span>";
	//else echo "<span style='color:green'> Username Available.</span>";
}
// End code check username

?>