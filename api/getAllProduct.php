<?php

    require_once('./db.php');
    //var getData = JSON.parse(localStorage.getItem('cartUser'));
    
    
    try {
        if($_SERVER['REQUEST_METHOD'] == 'GET') {
            $object = new stdClass();

            $stmt = $db->prepare('select * from sp_product order by product_id asc');

            if($stmt->execute()){
                $num = $stmt->rowCount();
                if($num > 0){
                    $object->Result = array();
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);

                        array_push($object->Result,$row);
                    }
                    $object->RespCode = 200;
                    $object->RespMessage = 'success';
                    http_response_code(200);
                }
                else {
                    $object->RespCode = 400;
                    $object->Log = 0;
                    $object->RespMessage = 'bad : Not found data';
                    http_response_code(400);
                }

                echo json_encode($object);
            }
            else {
                $object->RespCode = 500;
                $object->Log = 1;
                $object->RespMessage = 'bad : bad sql';
                http_response_code(400);
            }
        }

        else if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $token = $_POST['token'];
            $query = "select * from sp_user where token = ?";
            $query = "select * from sp_transaction where token = ?";
            $stmt = $db->prepare($query);
            if($stmt->execute([
                $token
            ])) {
                $num = $stmt->rowCount();
                if($num == 1) {
                    $userid = 0;
                    $transid =0;
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $userid = $user_id;
                        //$transid = $trans_id; ไม่ใส่แล้วรันถูกต้อง
                    }

    
                    $query = "select * from sp_transaction where user_id = ? AND transid = ?";
                    //$query = "select * from sp_transaction where user_id = 45 AND transid = 1680368918280";
                    //$query = "select * from sp_transaction where user_id = ?";
                    $stmt = $db->prepare($query);
                    if($stmt->execute([
                        $userid,
                        $transid,
                    ])) {
                        $num = $stmt->rowCount();

                        //num ตรงนี้คือถ้ามากกว่า0 คือมีสินค้ามากกว่า1ชิ้น
                        if($num > 0) {
                            $object = new stdClass();
                            $object->Result = array();
    
    
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);
                                
                                /*var a = JSON.parse($orderlist);
                                var b = a[0].namePro;*/
                                //"orderlist" => JSON.parse($orderlist),
                                
                                $items = array(
                                    "orderlist" => $orderlist,
                                    "user_id" => $user_id,
                                    "transid" => $transid,
                                    "amount" => $amount,
                                    "shipping" => $shipping,
                                    "vat" => $vat,
                                    "netamount" => $netamount,
                                    "updated_at" => $updated_at,
                                    "operation" => $operation,
                                );
                                array_push($object->Result, $items);
                            }
    
                            $object->RespCode = 200;
                            $object->RespMessage = 'success';
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
                        $object->RespMessage ='bad';
                        $object->Log = 3;
                    }
    
    
                }
                else {
                    $object = new stdClass();
                    $object->RespCode =400;
                    $object->RespMessage ='bad';
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
    }
    catch(PEOException $e) {
        http_response_code(500);
        echo $e->getMessage();
    }


?>
