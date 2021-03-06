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
        <h3>UserInfo table</h3>
        <?php
        $id = $_GET['id'];
        include("connect.php");
        $sql = "SELECT id,username, firstName ,lastName ,phoneNumber  ,email  ,address  ,balance FROM UserInfo where id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            $row = $result->fetch_assoc();
        }
        ?>
        <form action="lastuserinfoupdate.php" method="post">
            id:<input type="text" name="id" readonly value="<?php echo $row['id']?>"><br>
            username:<input type="text" name="username" value="<?php echo $row['username']?>"><br>
            firstName: <input type="text" name="firstName" value="<?php echo $row['firstName']?>"><br>
            lastName: <input type="text" name="lastName" value="<?php echo $row['lastName']?>"><br>
            phoneNumber: <input type="text" name="phoneNumber" value="<?php echo $row['phoneNumber']?>"><br>
            email: <input type="text" name="email" value="<?php echo $row['email']?>"><br>
            address: <input type="text" name="address" value="<?php echo $row['address']?>"><br>
            balance: <input type="text" name="balance" value="<?php echo $row['balance']?>"><br>
            <input type="submit" value="update">
        </form>
        <?php
        $conn->close();
        ?>
    </div>
</div>
</body>
</html>
