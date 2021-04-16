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
        <h3>OrderItem Table</h3>
        <?php
        include("connect.php");
        $sql = "SELECT id, orderId  ,tripId  ,productId FROM OrderedItem    ";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row

            echo "<table><tr><th>ID</th><th>orderId</th><th>tripId</th><th>productId</th></tr>";
            while ($row = $result->fetch_assoc()) {

                echo "<tr><td>".$row["id"]."</td><td>".$row["orderId"]."</td><td>".$row["tripId"]."</td><td>".$row["productId"]."</td>"."<td><a href='orderitemdelete.php?id={$row['id']}' >delete</a></td></tr>";
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