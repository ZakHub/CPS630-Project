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
        <h3>Store table</h3>
        <?php
        include("connect.php");
        $sql = "SELECT id, storeName, lat, lng FROM store";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row

            echo "<table><tr><th>ID</th><th>StoreName</th><th>LAT</th><th>LNG</th></tr>";
            while ($row = $result->fetch_assoc()) {

                echo "<tr><td>".$row["id"]."</td><td>".$row["storeName"]."</td><td>".$row["lat"]."</td><td>".$row["lng"]."</td>"."<td><a href='storedelete.php?id={$row['id']}' >delete</a></td></tr>";
            }
            echo "</table>";
        } else {
            echo "There are nothing available at the moment. Please try again later.";
        }
        $conn->close();
        ?>
 </div>
</div>
</body>
</html>
