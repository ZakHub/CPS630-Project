<!DOCTYPE html>

<html lang="en">
<head>
  <?php include('common.php'); ?>
  <title>GQZ Travels - Checked Out</title>
  <script>
    function submitReview() {
      var xhttp = new XMLHttpRequest();
      xhttp.open('POST', 'api/savereview.php', true);
      xhttp.onreadystatechange = function () {
        if (this.readyState !== 4 || this.status !== 200) {
          return;
        }
        const response = JSON.parse(this.responseText);
        if (response.status === 'Failed') {
          alert('Failed to save review. Check console for details');
          console.error(response.error);
          return;
        }
        document.getElementById('review-section').innerHTML =
          '<p>Thank you for your feedback</p>';
      };
      xhttp.timeout = 2000;
      xhttp.ontimeout = function () {
        alert('Failed to save review. Request timed out');
      };
      xhttp.setRequestHeader('Content-Type', 'text/plain;charset=UTF-8');
      xhttp.send(document.getElementById('review-input').value);
    }
  </script>
</head>
<body>
  <div id="outer">
    <div id="inner" class="floating">
      <?php include('navbar.php'); ?>
      <h1>Order Placed</h1>
      <h2>Successfully placed order #<?= $_GET['orderId'] ?></h2>
      <div id="review-section">
        <p>Please give us your feedback</p>
        <textarea id="review-input" maxlength="65536" rows="10" cols="40"></textarea>
        <br />
        <button type="button" onclick="submitReview();">Submit</button>
      </div>
    </div>
  </div>
</body>
</html>
