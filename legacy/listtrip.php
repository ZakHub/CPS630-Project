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
        include("connect.php");
        $sql = "SELECT id, fromLat,fromLng,toLat ,toLng ,distance ,carId ,price FROM Trip ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            echo "<table><tr><th>ID</th><th>fromLat</th><th>fromLng</th><th>toLat</th><th>toLng</th><th>distance</th><th>carId</th><th>price</th></tr>";
            while ($row = $result->fetch_assoc()) {

                echo "<tr><td>".$row["id"]."</td><td>".$row["fromLat"]."</td><td>".$row["fromLng"]."</td><td>".$row["toLat"]."</td><td>".$row["toLng"]."</td><td>".$row["distance"]."</td><td>".$row["carId"]."</td><td>".$row["price"]."</td><td><a href='tripdelete.php?id={$row['id']}' >delete</a></td></tr>";
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