function logoutController($scope, $window, $timeout)
{
	$window.sessionStorage.removeItem('user');
	$window.sessionStorage.removeItem('cart');
	$timeout(function () {
		$window.location.href = '#!/';
	}, 2000);
}
