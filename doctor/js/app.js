///<reference path="angular-route.js" />
/*
*The purpose of this script is to add angularJS functionality to the web appCodeName
* Inside is all controllers and modules for the app.
*/

//below is the app module and the module for routing

var myApplication = angular.module('myApplication', []);
var myApp = angular.module('myApplication', ['ngRoute']);

//login controller that ensure input are entered before the button enable, or else disable the button

myApp.controller("loginController",['$scope', '$log', function ($scope, $log) { 
	$scope.reset = function(){ 
	
	$scope.passWord=""; 
	$scope.userName=""; 
  }    
 $scope.reset(); 
	  
}]);