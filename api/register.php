<?php
    /*require_once('./db.php');
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
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phonenumber = $_POST['phonenumber'];

        $salt = generateRandomString(10);
        $newpassword = md5($password.$salt);
        
        $now = date("Y-m-d H:i:s");
        $token = md5(generateRandomString(10).$now);
        
        $query = "insert into sp_user (username, password, salt, token, firstname, lastname, email,
        address, phonenumber) values (?,?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($query);
        if($stmt->execute([
            $username, $newpassword, $salt, $token, $firstname, $lastname, $email
            ,$address, $phonenumber
        ])) {
            $object = new stdClass();
            $object->RespCode =200;
            $object->RespMessage ='good';
            $object->Token =$token;
            $object->firstname =$firstname;
            $object->lastname =$lastname;
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
    }*/




    /////////////////////////////////////////////////////////
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
        $username = $_POST['username'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $phonenumber = $_POST['phonenumber'];

        $salt = generateRandomString(10);
        $newpassword = md5($password.$salt);
        
        $now = date("Y-m-d H:i:s");
        $token = md5(generateRandomString(10).$now);

        

        $object = new stdClass();
        //$sql="select * from sp_user where (username='$username' or email='$email');";
        $sql="select * from sp_user where username = ? or email = ?";
        $stmt = $db->prepare($sql);
        if($stmt->execute([
            $username,$email
        ])) {
            $num = $stmt->rowCount();
            if($num == 1) {
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    if($email==isset($row['email'])){
                        $object = new stdClass();
                        $object->RespCode =200;
                        //$object->RespMessage ='bad: email already exists';
                        $object->Log = 3;
                        echo "email already exists";
                    }
                    if($username==isset($row['username'])){
                        $object = new stdClass();
                        $object->RespCode =200;
                        //$object->RespMessage ='bad: username already exists';
                        $object->Log = 4;
                        echo "username  already exists";
		            }
                }
            }
        //}
        else {
        $query = "insert into sp_user (username, password, salt, token, firstname, lastname, email,
        address, phonenumber, role_id) values (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $db->prepare($query);
        if($stmt->execute([
            $username, $newpassword, $salt, $token, $firstname, $lastname, $email
            ,$address, $phonenumber, 2
        ])) {
            $object = new stdClass();
            $object->RespCode =200;
            $object->RespMessage ='good';
            $object->Token =$token;
            $object->firstname =$firstname;
            $object->lastname =$lastname;
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

    }
    else {
        http_response_code(405);
    }
}

?>