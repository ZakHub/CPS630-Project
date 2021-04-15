function starRatingDirective()
{
	return {
		restrict: 'A',
		template: '<ul class="rating">' +
			'<li ng-repeat="star in stars" ng-class="star" ng-click="toggle($index)">' +
			'<em>\u272A</em>' +
			'</li>' +
			'</ul>',
		scope: {
			ratingValue: '=',
			max: '=',
			onRatingSelected: '&'
		},
		link: function (scope, elem, attrs) {

			var updateStars = function () {
				scope.stars = [];
				for (var i = 0; i < scope.max; i++) {
					scope.stars.push({
						filled: i < scope.ratingValue
					});
				}
			};

			scope.toggle = function (index) {
				scope.ratingValue = index + 1;
				scope.onRatingSelected({
					rating: index + 1
				});
			};

			scope.$watch('ratingValue', function (oldVal, newVal) {
				if (newVal) {
					updateStars();
				}
			});
		}
	};
}

function initStarRating($scope, max)
{
	$scope.rating = 0;
    $scope.ratings = [{
        presentV: 2,
        max: max
    }];
    
    $scope.getStarRating = function (i) {
		return $scope.ratings[i].presentV;
	}
	
	$scope.getMaxStarRating = function (i) {
		return $scope.ratings[i].max;
	}
}
