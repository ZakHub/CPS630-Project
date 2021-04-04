function reviewsController($scope, $http)
{
	function failed(response)
	{
		
	}
	
	//$http({ method: 'GET', url: 'api/retrievereviews.php' })
	$http.get('api/retrievereviews.php').then(function (response) {
		$scope.success = true;
		$scope.reviews = response.data.results;
	}, function (response) {
		$scope.success = false;
		alert('Failed to retrieve reviews. Check log for further details');
		console.error(response.data || 'Request failed with unspecified reason');
	});
}
