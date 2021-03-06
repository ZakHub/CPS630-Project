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
        <h3>Product table information</h3>
        <form action="productinsert.php" method="post">
            Description:<input type="text" name="Description"><br>
            StoreId:<input type="text" name="StoreId"><br>

            <input type="submit">
            <input type="reset">
        </form>

    </div>
</div>
</body>
</html>
