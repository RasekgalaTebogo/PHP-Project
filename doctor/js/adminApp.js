


// create the module and name it myModule
var myModule = angular.module('myApp',['ngRoute']);

//configure our route
myModule.config(function($routeProvider){
	
	$routeProvider
	
	//route for the first page
	.when('/', {
		templateUrl:'pages/manage.php',
		controller:'searchController'
	})
	
	//route to all doctor page
	.when('/view',{
		templateUrl:'pages/viewdoctors.php',
		controller:'viewController'
	})
	
	//route to the doctor registration page
	.when('/register',{
		templateUrl:'pages/registration.php',
		controller:'registerController'
	})
});

//controller for searching
myModule.controller("searchController",['$scope', '$log', function ($scope, $log) { 

		
}]);

//controller for the view all doctor
myModule.controller("viewController",['$scope', '$log', function ($scope, $log) { 

		
}]);

//controller for registration
myModule.controller("registerController",['$scope', '$log', function ($scope, $log) { 

		
}]);
