function serviceAController($scope, $http, $window, leafletData)
{
	if (!$window.sessionStorage['user']) {
		$window.location.href = '#!/login?from=services/a';
	}
	
	const OSM = 'https://nominatim.openstreetmap.org';
	var route = null;
	
	$scope.routeConfirmed = false;
	$scope.cars = [];
	
	$scope.trip = {
		fromAddr: {
			street: '',
			city: '',
			province: '',
			country: ''
		},
		fromPos: null,
		toAddr: {
			street: '',
			city: '',
			province: '',
			country: ''
		},
		toPos: null,
		date: null,
		car: null,
		distance: null,
		cost: null
	};
	
	$scope.startPosition = {
		lat: 0,
		lng: 0,
		zoom: 12
	};
	
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (pos) {
			$scope.$apply(function () {
				//console.log(pos);
				$scope.startPosition.lat = pos.coords.latitude;
				$scope.startPosition.lng = pos.coords.longitude;
				
				$http.get(OSM + '/reverse?format=json&lat=' +
					$scope.startPosition.lat + '&lon=' +
					$scope.startPosition.lng).then(function (response) {
					const result = response.data;
					const address = result.address;
					
					$scope.trip.fromAddr.street = address.house_number + ' ' +
						address.road;
					$scope.trip.fromAddr.city = address.city;
					$scope.trip.fromAddr.province = address.state;
					$scope.trip.fromAddr.country = address.country;
					
					$scope.trip.toAddr.province = address.state;
					$scope.trip.toAddr.country = address.country;
				}, function (response) {
					console.warn('Failed to lookup current address');
				});
			});
		});
	} else {
		console.warn('geolocation is not supported');
	}
	
	$scope.populateVehicles = function () {
		if (!$scope.trip.date) {
			return;
		}
		$http.get('api/retrievecars.php?date=' + $scope.trip.date)
			.then(function (response) {
			$scope.cars = response.data.results;
		}, function (response) {
			alert('Failed to retrieve list of available vehicles. ' +
				'Try refreshing the page');
			console.error(response);
		});
	};
	
	$scope.updateRoute = async function () {
		const addressFields = [ 'street', 'city', 'province', 'country' ];
		
		function verifyAddress(addr)
		{
			for (var field of addressFields) {
				if (!addr[field]) {
					return false;
				}
			}
			return true;
		}
		
		function constructAddress(addr)
		{
			if (!verifyAddress(addr)) {
				return null;
			}
			var address = '';
			for (var i = 0; i < addressFields.length; i++) {
				if (i) {
					address += ', ';
				}
				address += addr[addressFields[i]];
			}
			
			return address;
		}
		
		const fromAddress = constructAddress($scope.trip.fromAddr);
		const toAddress = constructAddress($scope.trip.toAddr);
		
		if (!fromAddress) {
			alert('Starting address is not correctly populated');
			return;
		}
		if (!toAddress) {
			alert('Destination address is not correctly populated');
			return;
		}
		
		// lookup lat/long for each address
		var fromResponsePromise = $http.get(OSM + '/search?format=json&q=' +
			fromAddress);
		var toResponsePromise = $http.get(OSM + '/search?format=json&q=' +
			toAddress);
			
			
		const fromResponse = await fromResponsePromise;
		if (fromResponse.status !== 200 || !fromResponse.data.length) {
			alert('Failed to lookup starting position');
			console.warn(fromResponse.data);
			return;
		}
		$scope.trip.fromPos = {
			lat: parseFloat(fromResponse.data[0].lat),
			lng: parseFloat(fromResponse.data[0].lon)
		};
		
		const toResponse = await toResponsePromise;
		if (toResponse.status !== 200 || !toResponse.data.length) {
			alert('Failed to lookup destination position');
			console.warn(toResponse.data);
			return;
		}
		$scope.trip.toPos = {
			lat: parseFloat(toResponse.data[0].lat),
			lng: parseFloat(toResponse.data[0].lon)
		};
		
		// update map center
		/*$scope.$apply(function () {
			$scope.position.lat = fromPosition.lat;
			$scope.position.lng = fromPosition.lng;
		});*/
		
		// construct route or update existing route
		leafletData.getMap().then(function (map) {
			map.fitBounds([$scope.trip.fromPos, $scope.trip.toPos]);
			if (!route) {
				route = L.Routing.control({
					waypoints: [ $scope.trip.fromPos, $scope.trip.toPos ],
					show: false
				}).on('routesfound', function (e) {
					const routes = e.routes;
					$scope.trip.distance = routes[0].summary.totalDistance / 1000;
					if ($scope.trip.distance > 50) {
						alert('Requested route exceeds transport limit of 50Km.');
						$scope.routeConfirmed = false;
					} else {
						$scope.routeConfirmed = true;
					}
				}).on('routeselected', function (e) {
					$scope.updateCost();
				});
				route.addTo(map);
			} else {
				route.setWaypoints([ fromPosition, toPosition ]);
			}
		});
	};
	
	$scope.updateCost = function () {
		if (!$scope.routeConfirmed || !$scope.trip.car) {
			return;
		}
		
		$scope.trip.cost = $scope.trip.distance * $scope.trip.car.rate;
	};
	
	$scope.addToCart = function () {
		console.log('addToCart called');
		console.log($scope.trip);
		
		var cart = JSON.parse($window.sessionStorage['cart']);
		cart.trips.push($scope.trip);
		$window.sessionStorage['cart'] = JSON.stringify(cart);
	};
}
