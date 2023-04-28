<?php
    require_once('./dbForADD.php');

    if(isset($_FILES['txt_file']['name'])){

        /* Getting file name */
        $filename = $_FILES['txt_file']['name'];
    
        /* Location */
        $location = "../images/".$filename;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);

        
    
        /* Valid extensions */
        $valid_extensions = array("jpg","jpeg","png");
    
        $response = 0;
        /* Check file extension */
        if(in_array(strtolower($imageFileType), $valid_extensions)) {
               /* Upload file */
               if(move_uploaded_file($_FILES['txt_file']['tmp_name'],$location)){
                 $response = $location;
                 move_uploaded_file($_FILES['txt_file']['tmp_name'],$location);
               }
        }
    
        echo $response;
        exit;
    }
    
    echo 0;
?>