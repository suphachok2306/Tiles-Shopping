<?php
    require_once('./db.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $tokenForOrder = $_POST['tokenFor'];
        $imageForPay = $_POST['imageFor'];
        //$imageForPay = $_FILES['txt_file']['name'];
        //$temp = $_FILES['txt_file']['tmp_name'];
        

        //$path = "../images/" . $imageForPay; // set upload folder path
        //move_uploaded_file($temp, '../images/'.$imageForPay); // move upload file temperory directory to your upload folder
            
        //copy($imageForPay, "./tiles-shop/images/"); 

        //$now = date("Y-m-d H:i:s");
        //$newTokenAfterCancel = md5(generateRandomString(10).$now);


        $query = "select * from sp_transaction where token = ?";
        $stmt = $db->prepare($query);
        if($stmt->execute([
            $tokenForOrder
        ])) {
            $num = $stmt->rowCount();
            if($num > 0) {
                $query = 'update sp_transaction set token = ?, operation = ?, img = ? where token = ?';
                //$query = 'update sp_transaction set token = ?, operation = ? where token = ?';
                $stmt = $db->prepare($query);
                if($stmt->execute([
                    null,
                    'รอตรวจสอบการชำระเงิน',
                    $imageForPay,
                    $tokenForOrder
                ])){
                    //localStorage.setItem('token',$token);
                    $object = new stdClass();
                    $object->RespCode =200;
                    $object->RespMessage ='good';
                }
                else {
                    $object = new stdClass();
                    $object->RespCode =400;
                    $object->RespMessage ='bad';
                    $object->Log = 2;
                }
            }
            else{

                $query = 'update sp_transaction set token = ?, operation = ?, img = ? where token = ?';
                //$query = 'update sp_transaction set token = ?, operation = ? where token = ?';
                $stmt = $db->prepare($query);
                if($stmt->execute([
                    null,
                    'รอตรวจสอบการชำระเงิน',
                    $imageForPay,
                    $tokenForOrder
                ])){
                    //localStorage.setItem('token',$token);
                    $object = new stdClass();
                    $object->RespCode =200;
                    $object->RespMessage ='good';
                }
                else {
                    $object = new stdClass();
                    $object->RespCode =400;
                    $object->RespMessage ='bad';
                    $object->Log = 5;
                }
            }
            
        }
        else {
            $object = new stdClass();
            $object->RespCode =400;
            $object->RespMessage ='bad';
            $object->Log = 1;
        }
        echo json_encode($object);
        http_response_code(200);
    }

    /*if(isset($_FILES['txt_file']['name'])){

        
        $filename = $_FILES['txt_file']['name'];
    
        
        $location = "../images/".$filename;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);

        
    
        $valid_extensions = array("jpg","jpeg","png");
    
        $response = 0;

        if(in_array(strtolower($imageFileType), $valid_extensions)) {

               if(move_uploaded_file($_FILES['txt_file']['tmp_name'],$location)){
                 $response = $location;
                 move_uploaded_file($_FILES['txt_file']['tmp_name'],$location);
               }
        }
    
        echo $response;
        exit;
    }
    
    echo 0;*/

    else {
        http_response_code(405);
    }
?>