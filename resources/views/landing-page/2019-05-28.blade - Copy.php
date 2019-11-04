<html>
  <head>
    <title>Datang</title>
    <!--  ANGULAR   -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <!--  ANGULAR   -->
  </head>
  <body ng-app="myApp" ng-controller="myCtrl">
  <div id="templateview"></div>
    
  </body>
  <script>
    var app = angular.module('myApp', []);
      app.controller('myCtrl', function($scope, $http){

        $http({
              method : 'GET',
              url : 'http://clothezon.com/api-farros.com/public/get-view', 
              headers: { 'X-Parse-Application-Id':'XXX', 'X-Parse-REST-API-Key':'YYY'}
        }).then(
          function successCallback(response) {
              $('#templateview').html(response);
              alert(response);
          },
          function errorCallback(response) {
            console.log("error");
          }
        );
      })

  </script>
</html>