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
        <h3>Order Information</h3>
        <?php
        include("connect.php");
        $sql = "SELECT id, orderDate ,fulfillmentDate ,price ,userId FROM OrderInfo   ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            echo "<table><tr><th>ID</th><th>orderDate</th><th>fulfillmentDate</th><th>price</th><th>userId</th></tr>";
            while ($row = $result->fetch_assoc()) {

                echo "<tr><td>".$row["id"]."</td><td>".$row["orderDate"]."</td><td>".$row["fulfillmentDate"]."</td><td>".$row["price"]."</td><td>".$row["userId"]."</td><td><a href='orderinfoupdate.php?id={$row['id']}' >update</a></td></tr>";
            }
        } else {
            echo "There are nothing available at the moment. Please try again later.";
        }
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>
