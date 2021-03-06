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
        <h3>Car table information</h3>
        <form action="carinsert.php" method="post">
            Model:<input type="text" name="Model"><br>
            Rate:<input type="text" name="Rate"><br>

            <input type="submit">
            <input type="reset">
        </form>

    </div>
</div>
</body>
</html>
