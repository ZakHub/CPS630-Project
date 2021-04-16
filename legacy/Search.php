<!DOCTYPE html>

<?php
include_once('connect.php');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>

<html lang="en">
<head>
  <?php include_once('common.php'); ?>
  <title>GQZ Travels - Search Results</title>
</head>
<body>
	<div id="outer">
		<div id="inner" class="floating">
			<?php include_once('navbar.php'); ?>
			<h1>Search results</h1>
			<h2>Results for query "<?= $_GET['search'] ?>"</h2>
			<br />
			<table>
				<tr>
					<th>ID</th>
					<th>Order Date</th>
					<th>Price</th>
					<th>User ID</th>
				</tr>
<?php
	try {
		$stmt = $conn->prepare('SELECT * FROM OrderInfo WHERE ? in (id, userId)');
		$stmt->bind_param('s', $_GET['search']);
		$stmt->execute();
		$result = $stmt->get_result();
		while ($row = $result->fetch_assoc()) {
				echo '<tr>' .
					'<td>' . $row['id'] . '</td>' .
					'<td>' . $row['orderDate'] . '</td>' .
					'<td>$' . number_format($row['price'], 2) . '</td>' .
					'<td>' . $row['userId'] . '</td>' .
				'</tr>';
		}
		$result->close();
		$stmt->close();
	} catch (mysqli_sql_exception $e) {
		echo $e;
	}
?>
			</table>
		</div>
	</div>
</body>
</html>

<?php $conn->close(); ?>
