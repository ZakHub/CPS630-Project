<!DOCTYPE html>

<?php include('connect.php'); ?>

<html lang="en">
<head>
  <?php include('common.php'); ?>
  <title>GQZ TRAVELS - Reviews</title>
</head>
<body>
  <div id="outer">
    <div id="inner" class="floating">
      <?php include('navbar.php'); ?>
      <h1>Reviews</h1>
      <h2>Check out what our customers have to say about us</h2>
<?php
  $query =
    'SELECT LEFT(ui.firstName, 1) AS firstInitial, LEFT(ui.lastName, 1) AS lastInitial, r.feedback ' .
    'FROM Review AS r ' .
    'INNER JOIN UserInfo AS ui ' .
    'ON ui.id = r.userId';
  if ($result = $conn->query($query)):
    while ($review = $result->fetch_assoc()):
?>
      <div class="review">
        <h3><?= $review['firstInitial'] ?>. <?= $review['lastInitial'] ?>. says:</h3>
        <p><?= $review['feedback'] ?></p>
      </div>
      <br />
<?php
    endwhile;
    $result->close();
  else:
?>
      <p><?= $conn->error ?></p>
<?php endif; ?>
    </div>
  </div>
</body>
</html>

<?php $conn->close(); ?>
