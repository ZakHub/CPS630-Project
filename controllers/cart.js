function cartController($scope, $window)
{
	if (!$window.sessionStorage['user']) {
		$window.location.href = '#!/login';
	}
	
	$scope.cart = JSON.parse($window.sessionStorage['cart']);
}
