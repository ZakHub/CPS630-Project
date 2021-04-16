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
        <h3>Car table</h3>
        <?php
        $id = $_GET['id'];
        include("connect.php");
        $sql = "SELECT id,model,rate FROM car where id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="lastcarupdate.php" method="post">
            id:<input type="text" name="id" readonly value="<?php echo $row['id']?>"><br>
            model:<input type="text" name="model" value="<?php echo $row['model']?>"><br>
            rate: <input type="text" name="rate" value="<?php echo $row['rate']?>"><br>

            <input type="submit" value="update">
        </form>
        <?php
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>