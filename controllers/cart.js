function cartController($scope, $window)
{
	if (!$window.sessionStorage['user']) {
		$window.location.href = '#!/login';
	}
	
	$scope.cart = JSON.parse($window.sessionStorage['cart']);
	
	$scope.delete = function (which, item) {
		const i = $scope.cart[which].indexOf(item);
		if (i > -1) {
			$scope.cart[which].splice(i, 1);
			$window.sessionStorage['cart'] = JSON.stringify($scope.cart);
		}
	};
	
	$scope.total = function () {
		return $scope.cart.products.map(p => p.price).reduce((a, b) => a + b, 0)
			+ $scope.cart.trips.map(t => t.cost).reduce((a, b) => a + b, 0);
	};
}
