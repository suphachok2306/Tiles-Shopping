<?php 
    require_once('./dbForTable.php');

    $sql = "SELECT user_id,username,firstname,email,phonenumber FROM sp_user where role_id = 2";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../table.css">
    <link rel="stylesheet" href="../admin.css">
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
        <h1>Users</h1>
        <table>
            <thead>
                <tr>
                    <td width="5%">#</td>
                    <td width="25%">ชื่อผู้ใช้</td>
                    <td width="25%">ชื่อจริง</td>
                    <td width="25%">อีเมลล์</td>
                    <td width="25%">เบอร์โทรศัพท์</td>
                </tr>
            </thead>
            <tbody>
             <!-- ข้อมูลที่เราจะทำการ fetch จากฐานข้อมูล -->
             <?php while($row = $result->fetch_assoc()): ?>
            <tr>

            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td class="name"><?php echo $row['firstname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['phonenumber']; ?></td>
            
            </tr>
            <?php endwhile ?>
            </tbody>
        </table>


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


</body>
</html>

