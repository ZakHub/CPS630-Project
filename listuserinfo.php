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
        <h3>Users Information</h3>
        <?php
        include("connect.php");
        $sql = "SELECT id,username, firstName ,lastName ,phoneNumber  ,email  ,address  ,balance FROM UserInfo  ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            echo "<table><tr><th>ID</th><th>username</th><th>firstName</th><th>lastName</th><th>phoneNumber</th><th>email</th><th>address</th><th>balance</th></tr>";
            while ($row = $result->fetch_assoc()) {

                echo "<tr><td>".$row["id"]."</td><td>".$row["username"]."</td><td>".$row["firstName"]."<td>".$row["lastName"]."</td><td>".$row["phoneNumber"]."</td><td>".$row["email"]."</td><td>".$row["address"]."</td><td>".$row["balance"]."</td><td>"."</td><td><a href=userinfodelete?id={$row['id']}' >delete</a></td></tr>";
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
