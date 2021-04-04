function serviceBController($scope, $http, $window)
{
	if (!$window.sessionStorage['user']) {
		$window.location.href = '#!/login';
	}
	
	$scope.drag = function (event) {
		event.dataTransfer.setData('text/plain', event.target.dataset.json);
	};
	
	$scope.allowDrop = function (event) {
		event.preventDefault();
	};
	
	$scope.drop = function (event) {
		event.preventDefault();
		var productJSON = event.dataTransfer.getData('text');
		console.log(productJSON);
	};
	
	$http.get('api/retrievestoreproducts.php').then(function (response) {
		$scope.stores = response.data.results;
	}, function (response) {
		console.log(response.data || 'Failed to retrieve stores for ' +
			'unspecified reason');
	});
}
