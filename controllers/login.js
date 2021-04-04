function loginController($scope, $http, $window)
{
	$scope.login = function (credentials) {
		console.log(credentials);
		$http.post('api/authenticate.php', JSON.stringify(credentials))
			.then(function (response) {
			const user = response.data.results;
			console.log(user);
			$window.sessionStorage.setItem('user', JSON.stringify(user));
			$window.location.href = '#!/';
		}, function (response) {
			console.log(response);
		});
	};
}
