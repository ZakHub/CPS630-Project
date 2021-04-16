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
        <h3>OrderInfo table</h3>
        <?php
        $id = $_GET['id'];
        include("connect.php");
        $sql = "SELECT id, orderDate ,fulfillmentDate ,price ,userId FROM OrderInfo where id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="lastorderinfoupdate.php" method="post">
            id:<input type="text" name="id" readonly value="<?php echo $row['id']?>"><br>
            orderDate:<input type="text" name="orderDate" value="<?php echo $row['orderDate']?>"><br>
            fulfillmentDate: <input type="text" name="fulfillmentDate" value="<?php echo $row['fulfillmentDate']?>"><br>
            price: <input type="text" name="price" value="<?php echo $row['price']?>"><br>
            userId: <input type="text" name="userId" value="<?php echo $row['userId']?>"><br>
            <input type="submit" value="update">
        </form>
        <?php
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>