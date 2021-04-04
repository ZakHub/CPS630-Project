function loginController($scope, $http, $window, $location)
{
	$scope.failed = false;
	
	$scope.login = function (credentials) {
		$scope.failed = false;
		$http.post('api/authenticate.php', JSON.stringify(credentials))
			.then(function (response) {
			var from = $location.search().from;
			if (!from) {
				from = '';
			}
			const user = response.data.results;
			const cart = {
				trips: [],
				products: []
			};
			if (user) {
				$window.sessionStorage.setItem('user', JSON.stringify(user));
				$window.sessionStorage.setItem('cart', JSON.stringify(cart));
				$window.location.href = '#!/' + from;
			} else {
				$scope.failed = true;
			}
		}, function (response) {
			$scope.failed = true;
			console.log(response.data || 'Request failed with unspecified reason');
		});
	};
}
