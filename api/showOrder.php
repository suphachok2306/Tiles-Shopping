<?php 
    require_once('./dbForTable.php');
    

    $sql = "SELECT user_id,transid,operation,updated_at FROM sp_transaction where operation = 'รอตรวจสอบการชำระเงิน' or operation = 'กำลังจัดส่ง'";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="../table.css">
    <link rel="stylesheet" href="../admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<div class="side" id="mySidebar">
                    <div class="side-header">
                    <h1>Tile Shopping</h1>
                    </div>
                    <hr style="border:1px solid; background-color:#8a7b6d; border-color:#3B3131;">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
                    <a href="./showUser.php"><i class="fa fa-th-list"></i> รายชื่อลูกค้า</a> 
                    <a href="./showOrder.php"><i class="fa-solid fa-users-line"></i> ประวัติการสั่งซื้อลูกค้า</a>
                    <a href="./add.php"><i class="fa fa-th"></i> เพิ่มสินค้า</a>
                    <a href="../login.html"><i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ</a> 
                    </div>

                <div id="main">
                    <button class="openbtn" onclick="openNav()"><i class="fa fa-bars"></i></button>
                </div>
    </div>
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
             <?php while($row = $result->fetch_assoc()): ?>
                <tr>
          <td><?=$row["user_id"]?></td>
          <td><?=$row["transid"]?></td>
           <?php 
            if($row["operation"]=='รอตรวจสอบการชำระเงิน'){
                            
            ?>
                <td><button class="btn btn-danger" onclick="ChangeOrderStatus('<?=$row['transid']?>')">รอตรวจสอบการชำระเงิน</button></td>
            <?php
                        
                }/*else{
            ?>
                <td><button class="btn btn-success" onclick="ChangeOrderStatus('<?=$row['transid']?>')">กำลังจัดส่ง</button></td>
        
            <?php
            }*/
            elseif($row["operation"]=='กำลังจัดส่ง'){
                            
                ?>
                    <td><button class="btn btn-success" onclick="ChangeOrderStatus('<?=$row['transid']?>')">กำลังจัดส่ง</button></td>
                <?php
                            
            }
            ?>
            <td><?=$row["updated_at"]?></td>
            <?php              
            ?>
        </tr>
            <?php endwhile ?>
            </tbody>
        </table>

        
        <script>
        function ChangeOrderStatus(id){
            $.ajax({
                url:"./updateOrderStatus.php",
                method:"post",
                data:{record:id},
                success:function(data){
           alert('เปลี่ยนสถานะรายการแล้ว');
           window.location.href = './showOrder.php' 
       }
            });
        }
        </script>

<script>
        function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
    //document.getElementById("main").style.marginLeft = "250px";  
    //document.getElementById("main-content").style.marginLeft = "250px";
    //document.getElementById("main").style.display="none";
  }
  
  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
    //document.getElementById("main").style.marginLeft= "0";  
    //document.getElementById("main").style.display="block";  
  }
    </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

