<?php
if(!empty($_POST )){
 
    // include database connection
    include 'config.php';
 
    try{
     
        // insert query
        $query = "INSERT INTO Driver SET Firstname=:firstname, Lastname=:lastname, Middlename=:middlename, DOB=:dob, Sex=:sex, Address=:address, National_ID=:nationalid, LicenseNo=:license, image=:image";
 
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
        $license=htmlspecialchars(strip_tags($_POST['license']));

        // new 'image' field
        $image=!empty($_FILES["image"]["name"])
        ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"])
        : "";
        $image=htmlspecialchars(strip_tags($image));

 
        // bind the parameters
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':middlename', $middlename);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':sex', $gender);
        $stmt->bindParam(':address',$address);
        $stmt->bindParam(':nationalid',$nationalid);
        $stmt->bindParam(':license',$license);
        $stmt->bindParam(':image', $image);
        // specify when this record was inserted to the database
        
         
        // Execute the query
        if($stmt->execute()){
           // echo "<div class='alert alert-success'>Record was saved.</div>";


            echo "<div class=\"alert alert-success alert-dismissible\">";
              echo  "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";
                echo "<h4><i class=\"icon fa fa-check\"></i> Success!</h4>";
                echo "Record was saved. <br>";
                echo "You can still proceed to add another Driver below.<i class=\"icon fa fa-smile-o\"></i> If not <a href='driverinfo.php'><h6>Click Here</h6></a> to go back to Driver Listing";
              echo "</div>";

            // now, if image is not empty, try to upload the image
        if($image){
         
            // sha1_file() function is used to make a unique file name
            $target_directory = "uploads/";
            $target_file = $target_directory . $image;
            $file_type = pathinfo($target_file, PATHINFO_EXTENSION);
         
            // error message is empty
            $file_upload_error_messages="";
         
        }

        // make sure that file is a real image
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check!==false){
            // submitted file is an image
        }else{
            $file_upload_error_messages.="<div>Submitted file is not an image.</div>";
        }
        }else{
            echo "<div class='alert alert-danger'>Unable to save record.</div>";
        }

        // make sure file does not exist
        /*if(file_exists($target_file)){
            $file_upload_error_messages.="<div>Image already exists. Try to change file name.</div>";
        }*/
        // make sure submitted file is not too large, can't be larger than 1 MB
        if($_FILES['image']['size'] > (1024000)){
            $file_upload_error_messages.="<div>Image must be less than 1 MB in size.</div>";
        }

        // make sure the 'uploads' folder exists
        // if not, create it
        if(!is_dir($target_directory)){
            mkdir($target_directory, 0777, true);
        }

        // if $file_upload_error_messages is still empty
        if(empty($file_upload_error_messages)){
            // it means there are no errors, so try to upload the file
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)){
                // it means photo was uploaded
            }else{
            /*    echo "<div class='alert alert-danger'>";
                    echo "<div>Unable to upload photo.</div>";
                    echo "<div>Update the record to upload photo.</div>";
                echo "</div>";*/
            }
        }
         
        // if $file_upload_error_messages is NOT empty
        else{
            // it means there are some errors, so show them to user
         /*   echo "<div class='alert alert-danger'>";
                echo "<div>{$file_upload_error_messages}</div>";
                echo "<div>Update the record to upload photo.</div>";
            echo "</div>";*/
        }
         
    }
     
    // show error
    catch(PDOException $exception){
        die('ERROR: ' . $exception->getMessage());
    }
}
?>