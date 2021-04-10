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
        <h3>Store table information</h3>
        <form action="storeinsert.php" method="post">
            Storename:<input type="text" name="storename"><br>
            lat:<input type="text" name="lat"><br>
            lng:<input type="text" name="lng"><br>
            <input type="submit">
            <input type="reset">
        </form>

    </div>
</div>
</body>
</html>
