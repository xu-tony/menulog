var app = angular.module('menulog', []);

app.controller('restaurantSearch', function($scope, $http) {

    //$scope.restaurants = [];
    $scope.requestRestaurants = function() {
        $scope.loading = true;
        $http({
            method : "GET",
            url : "/restaurants"+"?q="+ $scope.postcode
        }).
            then(function mySuccess(response) {
                $scope.restaurants = response.data;
                $scope.loading = false;
            }, function myError(response) {
                $scope.myWelcome = response.statusText;
                $scope.loading = false;
            });

    };

    $scope.orderByMe = function(x) {
        $scope.myOrderBy = x;
    };
});


app.controller('restaurantDetail', function($scope, $http) {

    $scope.getDetail = function(reId) {
        $scope.loading = true;
        $http({
            method: "GET",
            url: "/restaurants/get/" + reId
        }).then(function mySuccess(response) {
            $scope.restaurantDetail = response.data;
            $scope.loading = false;

            if($scope.restaurantDetail.menus.length > 0){
                $scope.hasDetail = true;
            } else {
                $scope.hasDetail = false;
            }
        },
        function myError(response) {
            $scope.myWelcome = response.statusText;
            $scope.loading = false;
        });
    }
});
