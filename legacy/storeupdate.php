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
$id = $_GET['id'];
include("connect.php");
$sql = "SELECT id, storeName, lat, lng FROM store where id=$id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    $row = $result->fetch_assoc();
}
?>
<form action="laststoreupdate.php" method="post">
    id:<input type="text" name="id" readonly value="<?php echo $row['id']?>"><br>
    Store Name:<input type="text" name="storeName" value="<?php echo $row['storeName']?>"><br>
    Lat: <input type="text" name="lat" value="<?php echo $row['lat']?>"><br>
    Lng: <input type="text" name="lng" value="<?php echo $row['lng']?>"><br>
    <input type="submit" value="update">
</form>

    </div>
</div>
</body>
</html>