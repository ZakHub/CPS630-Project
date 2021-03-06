<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('common.php'); ?>
    <title>GQZ TRAVELS - Travel Service</title>
</head>
<body>
<div id="outer">
    <div id="inner" class="floating">
        <!-- Navigation -->
        <?php include('navbar.php'); ?>
        <br><br><br>
        <h3>Product table</h3>
        <?php
        $id = $_GET['id'];
        include("connect.php");
        $sql = "SELECT id,description,storeId,price FROM product where id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="lastproductupdate.php.php" method="post">
            id:<input type="text" name="id" readonly value="<?php echo $row['id']?>"><br>
            description:<input type="text" name="description" value="<?php echo $row['description']?>"><br>
            storeId: <input type="text" name="storeId" value="<?php echo $row['storeId']?>"><br>
            price: <input type="text" name="price" value="<?php echo $row['price']?>"><br>
            <input type="submit" value="update">
        </form>

    </div>
</div>
</body>
</html>
