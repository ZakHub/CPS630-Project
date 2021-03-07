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
        include("connect.php");
        $sql = "SELECT id, description, storeId FROM product";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            echo "<table><tr><th>ID</th><th>description</th><th>storeId</th></tr>";
            while ($row = $result->fetch_assoc()) {

                echo "<tr><td>".$row["id"]."</td><td>".$row["description"]."<td>".$row["storeId"]."</td>"."<td><a href='productupdate.php?id={$row['id']}' >update</a></td></tr>";
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
