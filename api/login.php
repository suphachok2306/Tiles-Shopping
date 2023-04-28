<?php
    require_once('./db.php');
    date_default_timezone_set("Asia/Bangkok");

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $txt_username = $_POST['username'];
        $txt_password = $_POST['password'];


        $now = date("Y-m-d H:i:s");
        $gettoken = md5(generateRandomString(10).$now);
 
        $query = "select * from sp_user where username = ?";
        $stmt = $db->prepare($query);
        if($stmt->execute([
            $txt_username

        ])) {
            $num = $stmt->rowCount();
            if($num > 0) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    //extract($row);  //ถ้าไม่ extract จะเรียกตัวแปรต้องใช้ $row['value...']

                    $encpassword = md5($txt_password.$row['salt']);
                    //$encpassword = md5($txt_password.$salt);
                    if($encpassword == $row['password']) {
                    //if($encpassword == $password) {
                        $userid = $row['user_id'];
                        //$userid = $user_id;

                        $query = 'update sp_user set token = ? where user_id = ?';
                        $stmt = $db->prepare($query);
                        if($stmt->execute([
                            $gettoken, $userid
                        ])) {
        
                            $object = new stdClass();
                            $result = new stdClass();

                            /*$result->Firstname = $firstname;
                            $result->Lastname = $lastname;
                            $result->Token = $gettoken;*/

                            /*$result->Firstname = $row['firstname'];
                            $result->Lastname = $row['lastname'];;
                            $result->Token = $gettoken;

                            $object->RespCode =200;
                            $object->RespMessage ='good';
                            $object->Result = $result;*/


                            if($row['role_id'] == '1'){
                                $result->Firstname = $row['firstname'];
                                $result->Lastname = $row['lastname'];
                                $result->UserID = $row['user_id'];
                                $result->Username = $row['username'];
                                $result->Token = $gettoken;
    
                                $object->RespCode =300;
                                $object->RespMessage ='admin';
                                $object->Result = $result;
                                //$_SESSION['$txt_username'] = $row['username'];
                            }elseif($row['role_id'] == '2'){
                                $result->Firstname = $row['firstname'];
                                $result->Lastname = $row['lastname'];;
                                $result->UserID = $row['user_id'];
                                $result->Username = $row['username'];
                                $result->Token = $gettoken;
    
                                $object->RespCode =200;
                                $object->RespMessage ='user';
                                $object->Result = $result;
                                //$_SESSION['$txt_username'] = $row['username'];
                            }
                        }
                        else {
                            $object = new stdClass();
                            $object->RespCode =400;
                            $object->RespMessage ='bad';
                            $object->Log = 4;

                        }
                    }
                    else {
                        $object = new stdClass();
                        $object->RespCode =400;
                        $object->RespMessage ='bad: username ถูก pass ผิด';
                        $object->Log = 3;
                    }
                }
            }
            else {
                $object = new stdClass();
                $object->RespCode =400;
                $object->RespMessage ='num ไม่เท่ากับ 1 คือเป็น 0 ไม่มีในระบบ';
                $object->Log = 2;
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