function serviceAController($scope, $http, $window)
{
	if (!$window.sessionStorage['user']) {
		$window.location.href = '#!/login?from=services/a';
	}
	
	$scope.cars = [];
	$scope.order = {
		fromStreet: '',
		fromCity: '',
		fromProvince: '',
		fromCountry: '',
		
		toStreet: '',
		toCity: '',
		toProvince: '',
		toCountry: '',
		
		date: '',
		carId: 0
	};
	
	$scope.position = {
		lat: 0,
		lng: 0,
		zoom: 12
	};
	
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (pos) {
			$scope.$apply(function () {
				//console.log(pos);
				$scope.position.lat = pos.coords.latitude;
				$scope.position.lng = pos.coords.longitude;
				
				$http.get('https://nominatim.openstreetmap.org/reverse?lat=' +
					$scope.position.lat + '&lon=' + $scope.position.lng +
					'&format=json').then(function (response) {
					const result = response.data;
					const address = result.address;
					
					$scope.order.fromStreet = address.house_number + ' ' +
						address.road;
					$scope.order.fromCity = address.city;
					$scope.order.fromProvince = address.state;
					$scope.order.fromCountry = address.country;
					
					$scope.order.toProvince = address.state;
					$scope.order.toCountry = address.country;
				}, function (response) {
					console.warn('Failed to lookup current address');
				});
			});
		});
	} else {
		console.warn('geolocation is not supported');
	}
	
	$scope.populateVehicles = function (order) {
		if (!order.date) {
			return;
		}
		$http.get('api/retrievecars.php?date=' + order.date)
			.then(function (response) {
			$scope.cars = response.data.results;
			console.log($scope.cars);
		}, function (response) {
			alert('Failed to retrieve list of available vehicles. ' +
				'Try refreshing the page');
			console.error(response);
		});
	};
	
	$scope.updateRoute = function () {
		const suffixes = [ 'Street', 'City', 'Province', 'Country' ];
		
		function verifyAddress(prefix)
		{
			for (var suffix of suffixes) {
				if (!$scope.order[prefix + suffix]) {
					return false;
				}
			}
			return true;
		}
		
		function constructAddress(prefix)
		{
			if (!verifyAddress(prefix)) {
				return null;
			}
			var address = '';
			for (var i = 0; i < suffixes.length; i++) {
				if (i) {
					address += ', ';
				}
				address += $scope.order[prefix + suffixes[i]];
			}
			
			return address;
		}
		
		const from = constructAddress('from');
		const to = constructAddress('to');
		
		if (!from) {
			alert('Starting address is not correctly populated');
			return;
		}
		if (!to) {
			alert('Destination address is not correctly populated');
			return;
		}
		
		// lookup lat/long for each address
		// construct route or update existing route
		
	};
}
