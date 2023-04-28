<?php
    require_once('./dbForADD.php');

    if(isset($_REQUEST['btn_insert'])){
        try{
            $name = $_REQUEST['txt_name'];
            $price = $_REQUEST['txt_price'];
            $desctiption = $_REQUEST['txt_description'];
            $type = $_REQUEST['txt_type'];

            $image_file = $_FILES['txt_file']['name'];
            $typeFile = $_FILES['txt_file']['type'];
            $size = $_FILES['txt_file']['size'];
            $temp = $_FILES['txt_file']['tmp_name'];

            $path = "../images/" . $image_file; // set upload folder path

            if (empty($name)) {
                $errorMsg = "กรุณาใส่ชื่อสินค้า";
            } else if (empty($price)) {
                $errorMsg = "กรุณาใส่ราคาสินค้า";
            } else if (empty($desctiption)) {
                $errorMsg = "กรุณาใส่รายละเอียดสินค้า";
            } else if (empty($type)) {
                $errorMsg = "กรุณาใส่ประเภทสินค้า";
            } else if (empty($image_file)) {
                $errorMsg = "กรุณาใส่รูปภาพสินค้า";
            } else if ($typeFile == "image/jpg" || $typeFile == 'image/jpeg' || $typeFile == "image/png" || $typeFile == "image/gif") {
                if (!file_exists($path)) { // check file not exist in your upload folder path
                    if ($size < 5000000) { // check file size 5MB
                        move_uploaded_file($temp, '../images/'.$image_file); // move upload file temperory directory to your upload folder
                    } else {
                        $errorMsg = "Your file too large please upload 5MB size"; // error message file size larger than 5mb
                    }
                } else {
                    $errorMsg = "File already exists... Check upload filder"; // error message file not exists your upload folder path
                }
            } else {
                $errorMsg = "Upload JPG, JPEG, PNG & GIF file formate...";
            }

            if(!isset($errorMsg)) {
                /*$insert_stmt = $db->prepare('INSERT INTO sp_product(name,price,description,type,img) VALUES (:fname,:fprice,:fdescription,:ftype,:fimg)');    
                $insert_stmt->bindParam(':fname', $name);
                $insert_stmt->bindParam(':fprice', $price);
                $insert_stmt->bindParam(':fdescription', $desctiption);
                $insert_stmt->bindParam(':ftype', $type);
                $insert_stmt->bindParam(':fimg', $image_file);*/

                $insert_stmt = $db->prepare('insert into sp_product(name,price,description,type,img) values (:fname,:fprice,:fdescription,:ftype,:fimg)');    
                $insert_stmt->bindParam(':fname', $name);
                $insert_stmt->bindParam(':fprice', $price);
                $insert_stmt->bindParam(':fdescription', $desctiption);
                $insert_stmt->bindParam(':ftype', $type);
                $insert_stmt->bindParam(':fimg', $image_file);             

                if ($insert_stmt->execute()) {
                    $insertMsg = "File Uploaded successfully...";
                    //header('refresh:2;../index.html'); //refresh 2sec 
                }
            }           
        }catch(PDOException $e) {
            $e->getMessage();
        }

    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มสินค้า</title>
    <link rel="stylesheet" href="../admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
    <div class="container text-center">
        <h1>เพิ่มรายการสินค้า</h1>
        <?php 
            if(isset($errorMsg)) {
        ?>
            <div class="alert alert-danger">
                <strong><?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>

        <?php 
            if(isset($insertMsg)) {
        ?>
            <div class="alert alert-success">
                <strong><?php echo $insertMsg; ?></strong>
            </div>
        <?php } ?>

        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row">
            <label for="name" class="col-sm-3 control-label">ชื่อ</label>
            <div class="col-sm-8">
                <input type="text" name="txt_name" class="form-control" placeholder="ชื่อสินค้า">
            </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
            <label for="price" class="col-sm-3 control-label">ราคา</label>
            <div class="col-sm-9">
                <input type="text" name="txt_price" class="form-control" placeholder="ราคา">
            </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
            <label for="desc" class="col-sm-3 control-label">รายละเอียด</label>
            <div class="col-sm-9">
                <input type="text" name="txt_description" class="form-control" placeholder="รายละเอียดสินค้า">
            </div>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
            <label for="type" class="col-sm-3 control-label">ประเภท</label>
            <div class="col-sm-9">
                <input type="text" name="txt_type" class="form-control" placeholder="ประเภทสินค้า">
            </div>
            </div>
        </div>
        
        <div class="form-group">
            <div class="row">
            <label for="image" class="col-sm-3 control-label">รูปภาพ</label>
            <div class="col-sm-9">
                <input type="file" name="txt_file" class="form-control">
            </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <input type="submit" name="btn_insert" class="btn btn-success" value="เพิ่มสินค้าลงระบบ">
                <input type="reset" class="btn btn-danger" value = "ยกเลิก">

            </div>
        </div>
    </form>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
  </body>
</html>