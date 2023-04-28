<?php

    include_once "./dbForTable.php";
   
    $transid=$_POST['record'];
    //echo $order_id;
    $sql = "SELECT user_id,transid,operation FROM sp_transaction where transid = '$transid'"; 
    $result=$conn-> query($sql);
  //  echo $result;

    $row=$result-> fetch_assoc();
    
   // echo $row["pay_status"];
    
    if($row["operation"] == 'รอตรวจสอบการชำระเงิน'){
         $update = mysqli_query($conn,"UPDATE sp_transaction SET operation = 'กำลังจัดส่ง' where transid='$transid'");
    }
    else if($row["operation"] == 'กำลังจัดส่ง'){
         $update = mysqli_query($conn,"UPDATE sp_transaction SET operation = 'รอตรวจสอบการชำระเงิน' where transid='$transid'");
    }
    

    
?>