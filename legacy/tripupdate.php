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
        <h3>Trip table</h3>
        <?php
        $id = $_GET['id'];
        include("connect.php");
        $sql = "SELECT id, fromLat,fromLng,toLat ,toLng ,distance ,carId ,price FROM Trip where id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="lasttripupdate.php" method="post">
            id:<input type="text" name="id" readonly value="<?php echo $row['id']?>"><br>
            fromLat:<input type="text" name="fromLat" value="<?php echo $row['fromLat']?>"><br>
            fromLng: <input type="text" name="fromLng" value="<?php echo $row['fromLng']?>"><br>
            toLat: <input type="text" name="toLat" value="<?php echo $row['toLat']?>"><br>
            toLng: <input type="text" name="toLng" value="<?php echo $row['toLng']?>"><br>
            distance: <input type="text" name="distance" value="<?php echo $row['distance']?>"><br>
            carId: <input type="text" name="carId" value="<?php echo $row['carId']?>"><br>
            price: <input type="text" name="price" value="<?php echo $row['price']?>"><br>
            <input type="submit" value="update">
        </form>
        <?php
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>
