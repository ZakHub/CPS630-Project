function logoutController($scope, $window)
{
	$window.sessionStorage.removeItem('user');
	$window.sessionStorage.removeItem('cart');
	$window.location.href = '#!/';
}
