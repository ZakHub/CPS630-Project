function cartController($scope, $http, $window)
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
	
	$scope.checkout = function () {
		console.log('checkout called');
		const order = {
			cart: $scope.cart,
			total: $scope.total().toFixed(2),
			user: JSON.parse($window.sessionStorage['user'])
		};
		console.log(order);
		$http.post('api/checkout.php', order).then(function (response) {
			const orderId = response.data.orderId;
			console.log(response);
			$scope.cart = new Cart();
			$window.sessionStorage['cart'] = JSON.stringify($scope.cart);
			$window.location.href = '#!/checkedout?orderId=' + orderId;
		}, function (response) {
			alert('Failed to checkout');
			console.error(response.data || 'Unspecified error occurred');
		});
	};
}
