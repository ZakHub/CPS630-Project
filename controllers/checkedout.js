function checkedOutController($scope, $http, $window, $location)
{
	$scope.orderId = $location.search().orderId;
	$scope.review = '';
	$scope.submitted = false;
	
	$scope.submitReview = function () {
		if (!$scope.review) {
			return;
		}
		
		const payload = {
			content: $scope.review,
			userId: JSON.parse($window.sessionStorage['user']).id
		};
		$http.post('api/savereview.php', payload).then(function (response) {
			$scope.submitted = true;
		}, function (response) {
			alert('Failed to save review. Try again later');
			console.error(response);
		});
	};
}
