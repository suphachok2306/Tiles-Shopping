<?php 
    require_once('./dbForTable.php');
    //$userIDFor=$_POST['getUser_id'];
    

    /*if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $user_idFor = $_POST['user_id'];

        $sql = "SELECT user_id,transid,operation,updated_at FROM sp_transaction where operation = 'รอตรวจสอบการชำระเงิน' and user_id = '$userIDFor'";
        $result = $conn->query($sql);
    }*/


    //$user_idFor = $_POST['getuser_id'];

    $sql = "SELECT user_id,transid,operation,updated_at FROM sp_transaction where (operation = 'รอตรวจสอบการชำระเงิน' or operation = 'กำลังจัดส่ง') and user_id = '45' ";
    $result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../table.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<div class="container">
    <h1>รายการสั่งซื้อ</h1>
        <table>
            <thead>
                <tr>
                    <td width="5%">#</td>
                    <td width="25%">Transaction id</td>
                    <td width="25%">สถานะ </td>
                    <td width="25%">เวลาสั่งซื้อ </td>
                </tr>
            </thead>
            <tbody>
             <!-- ข้อมูลที่เราจะทำการ fetch จากฐานข้อมูล -->
             <?php
             while($row = $result->fetch_assoc()): 
             ?>
                <tr>
          <td><?=$row["user_id"]?></td>
          <td><?=$row["transid"]?></td>
          <td><?=$row["operation"]?></td>
          <td><?=$row["updated_at"]?></td>
        </tr>
            <?php endwhile ?>
            </tbody>
        </table>


        <script>
            /*$(document).ready(() => {
            $.ajax({
                method: 'post',
                url: './api/showOrderUser.php',
                data: {
                    getuser_id: localStorage.user_id
                }
            })
        })*/
        </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

