function loginController($scope, $http, $window)
{
	$scope.failed = false;
	
	$scope.login = function (credentials) {
		console.log(credentials);
		$http.post('api/authenticate.php', JSON.stringify(credentials))
			.then(function (response) {
			const user = response.data.results;
			console.log(user);
			if (user) {
				$window.sessionStorage.setItem('user', JSON.stringify(user));
				$window.location.href = '#!/';
			} else {
				$scope.failed = true;
			}
		}, function (response) {
			console.log(response.data || 'Request failed with unspecified reason');
		});
	};
}
