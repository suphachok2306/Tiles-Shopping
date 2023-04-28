<?php
    require_once('./db.php');
    try {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $object = new stdClass();
            $amount = 0;
            $product = $_POST['product'];
            $token = $_POST['token'];

        
            $stmt = $db->prepare('select product_id,price from sp_product order by product_id desc');
            
            if($stmt->execute()) {

                $queryproduct = array();
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    extract($row);
                    $items = array(
                        "id" => $product_id,
                        "price" => $price
                    );
                    array_push( $queryproduct, $items );
                }
                //inval(); แปลง str to int

                for ($i=0; $i < count($product) ; $i++) { 
                    for ($k=0; $k < count($queryproduct) ; $k++) { 
                        if( intval($product[$i]['id']) == intval($queryproduct[$k]['id']) ) {
                            $amount += intval($product[$i]['count']) * intval($queryproduct[$k]['price']);
                            break;
                        }
                    }
                }

                /*$shiping = $amount + 60;
                $vat = $shiping * 7 / 100;
                $netamount = $shiping + $vat;
                $transid = round(microtime(true) * 1000);
                $product = json_encode($product);
                $mil = time()*1000;
                $updated_at = date("Y-m-d h:i:sa");*/
                $shiping = 60;
                $vat = ($amount + $shiping) * 7 / 100;
                $netamount = $amount + $shiping + $vat;
                $transid = round(microtime(true) * 1000);
                $product = json_encode($product);
                //$mil = time()*1000;
                $updated_at = date("Y-m-d h:i:sa");


                
                //$stmt = $db->prepare('select user_id from sp_user where token = ?');

                $query = "select user_id from sp_user where token = ?";
                $stmt = $db->prepare($query);
                if($stmt->execute([
                    $token
                ]))  {
                    $queryproduct = array();
                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
                        $items = array(
                        "user_id" => $user_id
                    );
                    array_push( $queryproduct, $items );
                }
                
                $user_id = 0;

                for ($k=0; $k < count($queryproduct) ; $k++) {
                    $user_id += intval($queryproduct[$k]['user_id']);
                    break;
                    }

                
                $stmt = $db->prepare('insert into sp_transaction (transid,orderlist,amount,shipping,vat,netamount,operation,updated_at,user_id,token) values (?,?,?,?,?,?,?,?,?,?)');

                if($stmt->execute([
                    $transid, $product, $amount, $shiping, $vat, $netamount, 'ยังไม่ชำระเงิน', $updated_at, $user_id ,$token
                ])) {
                    
                    $object->RespCode = 200;
                    $object->RespMessage = 'success';
                    $object->Amount = new stdClass();
                    $object->Amount->Amount = $amount;
                    $object->Amount->Shipping = $shiping;
                    $object->Amount->Vat = $vat;
                    $object->Amount->Netamount = $netamount;
                    
                    
                    $object->Amount->Orderlist = $product;

                    http_response_code(200);
                }
                else {
                    $object->RespCode = 300;
                    $object->Log = 0;
                    $object->RespMessage = 'bad : insert transaction fail';
                    http_response_code(300);
                }
            }

            }
            else {
                $object->RespCode = 500;
                $object->Log = 1;
                $object->RespMessage = 'bad : cant get product';
                http_response_code(500);
            }
            echo json_encode($object);
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