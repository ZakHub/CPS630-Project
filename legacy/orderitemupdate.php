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
        <h3>orderItem table</h3>
        <?php
        $id = $_GET['id'];
        include("connect.php");
        $sql = "SELECT id, orderId  ,tripId  ,productId FROM OrderedItem where id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="lastorderitemupdate.php" method="post">
            id:<input type="text" name="id" readonly value="<?php echo $row['id']?>"><br>
            orderId:<input type="text" name="orderId" value="<?php echo $row['orderId']?>"><br>
            tripId: <input type="text" name="tripId" value="<?php echo $row['tripId']?>"><br>
            productId: <input type="text" name="productId" value="<?php echo $row['productId']?>"><br>
            <input type="submit" value="update">
        </form>
        <?php
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>
