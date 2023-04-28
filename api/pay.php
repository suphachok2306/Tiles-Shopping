<?php
    require_once('./db.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $tokenForOrder = $_POST['tokenFor'];

        //$now = date("Y-m-d H:i:s");
        //$newTokenAfterCancel = md5(generateRandomString(10).$now);


        $query = "select * from sp_transaction where token = ?";
        $stmt = $db->prepare($query);
        if($stmt->execute([
            $tokenForOrder
        ])) {
            $num = $stmt->rowCount();
            if($num > 0) {
                $query = 'update sp_transaction set token = ?, operation = ? where token = ?';
                $stmt = $db->prepare($query);
                if($stmt->execute([
                    null,
                    'ยกเลิกรายการ',
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
                /*$object = new stdClass();
                $object->RespCode =400;
                $object->RespMessage ='bad';
                $object->Log = 3;*/
                $query = 'update sp_transaction set token = ?, operation = ? where token = ?';
                $stmt = $db->prepare($query);
                if($stmt->execute([
                    null,
                    'ยกเลิกรายการ',
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
    else {
        http_response_code(405);
    }
?>