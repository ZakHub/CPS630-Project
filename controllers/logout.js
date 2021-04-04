function logoutController($scope, $window)
{
	$window.sessionStorage.removeItem('user');
}
