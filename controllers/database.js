function databaseController($scope, $http)
{
	$scope.table = null;
	$scope.cols = null;
	$scope.rows = null;
	$scope.newRow = { };

	$scope.setTable = function (table) {
		$scope.table = table;
		$scope.sortField = 'id';
		$scope.reverse = false;
		$http.get('api/database.php?mode=cols&table=' + table).then(
			function (response) {
			$scope.cols = parse_columns(response.data);
		}, function (response) {
			alert('Failed to retrieve rows for table ' + table);
			console.error(response.data || 'Failed to retrieve rows with unspecified reason');
		});
		$http.get('api/database.php?mode=rows&table=' + table).then(
			function (response) {
			$scope.rows = response.data;
		}, function (response) {
			alert('Failed to retrieve rows for table ' + table);
			console.error(response.data || 'Failed to retrieve rows with unspecified reason');
		});
	};

	$scope.updateRow = function (row) {
		$http.put('api/database.php?mode=update&table=' + $scope.table, row).then(function (response) {
			console.log(response);
		}, function (response) {
			alert('Failed to update row with index ' + row.id);
			console.error(response.data || 'Failed to update row with unspecified reason.');
		});
	};

	$scope.deleteRow = function (row) {
		$http.delete('api/database.php?mode=delete&table=' + $scope.table, { data: row }).then(function (response) {
			$scope.rows = $scope.rows.filter(function (r) { return r.id != row.id; });
		}, function (response) {
			alert('Failed to delete row with index ' + row.id);
			console.error(response.data || 'Failed to delete row with unspecified reason');
		});
	};
	
	$scope.addRow = function (row) {
		$http.put('api/database.php?mode=add&table=' + $scope.table, row).then(function (response) {
			row.id = response.data.id;
			$scope.rows.push(row);
			$scope.newRow = { };
		}, function (response) {
			alert('Failed to add new row');
			console.error(response.data || 'Failed to add new row with unspecified reason');
		});
	}

	$http.get('api/database.php?mode=tables').then(function (response) {
		$scope.tables = response.data;
	}, function (response) {
		alert('Failed to retrieve table list');
		console.error(response.data || 'Failed to retrieve table list for unknown reason');
	});
}

