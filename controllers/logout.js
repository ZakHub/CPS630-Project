function logoutController($scope, $window, $timeout)
{
	$window.sessionStorage.removeItem('user');
	$timeout(function () {
		$window.location.href = '#!/';
	}, 2000);
}
