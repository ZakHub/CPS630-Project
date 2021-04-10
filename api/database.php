<?php

require_once('connect.php');

$mode = $_GET['mode'];

$response = array();

try {
	switch ($mode) {
	case 'tables':
		{
			//$query = 'SHOW TABLES';
			$query = 'SELECT table_name AS name 
				FROM information_schema.tables
				WHERE table_schema="' . $dbname . '"';
			$results = $conn->query($query);
			while (($row = $results->fetch_assoc())) {
				array_push($response, $row);
			}
			$results->close();
		}
		break;
	case 'cols':
		{
			if (!isset($_GET['table'])) {
				respond(500, 'Missing GET parameter "table"');
			}

			$query = 'SHOW COLUMNS FROM ' . $_GET['table'];
			$results = $conn->query($query);
			while (($row = $results->fetch_assoc())) {
				array_push($response, $row);
			}
			$results->close();
		}
		break;
	case 'rows':
		{
			if (!isset($_GET['table'])) {
				respond(500, json_encode('Missing GET parameter "table"'));
			}

			$query = 'SELECT * FROM ' . $_GET['table'];
			$result = $conn->query($query);
			while (($row = $result->fetch_assoc())) {
				array_push($response, $row);
			}
			$result->close();
		}
		break;
	case 'add':
		{
			if (!isset($_GET['table'])) {
				respond(500, 'Missing GET parameter "table"');
			}
			$payload = json_decode(file_get_contents('php://input'));
			$query = 'INSERT INTO ' . $_GET['table'] . '(';
			$first = true;
			$argtypes = '';
			foreach ($payload as $key => $value) {
				if (key == 'id') {
					continue;
				}
				if (!$first) {
					$query = $query . ', ';
				}
				$query = $query . $key;
				$argtypes = $argtypes . 's';
				$first = false;
			}
			$query = $query . ') VALUES (';
			$args = array($argtypes);
			$first = true;
			foreach ($payload as $key => $value) {
				if ($key == 'id') {
					continue;
				}
				if (!$first) {
					$query = $query . ', ';
				}
				$query = $query . '?';
				array_push($args, $value);
				$first = false;
			}
			$query = $query . ')';

			//respond(500, json_encode(array('query' => $query)));
			$stmt = $conn->prepare($query);
			array_unshift($args, $stmt);
			call_user_func_array(mysqli_stmt_bind_param, $args);
			$stmt->execute();
			$response['id'] = $conn->insert_id;
			$stmt->close();
		}
		break;
	case 'delete':
		{
			if (!isset($_GET['table'])) {
				respond(500, json_encode('Missing GET parameter "table"'));
			}
			$payload = json_decode(file_get_contents('php://input'));
			$query = 'DELETE FROM ' . $_GET['table'] . ' WHERE id = ?';
			$stmt = $conn->prepare($query);
			$stmt->bind_param('i', $payload->id);
			$stmt->execute();
			$stmt->close();
		}
		break;
	case 'update':
		break;
	default:
		respond(500, 'Unrecognized API mode \'' . mode . '\'.');
		break;
	}
} catch (mysqli_sql_exception $e) {
	respond(500, json_encode($e));
}

$conn->close();

respond(200, json_encode($response));

?>
