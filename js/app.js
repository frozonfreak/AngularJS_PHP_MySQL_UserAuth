var phpuserauth = angular.module('phpuserauth',['ui.bootstrap','ui.router','mobile-angular-ui','mobile-angular-ui.gestures','mobile-angular-ui.migrate','angular-md5']).run(function($rootScope){
      $rootScope.userAgent = navigator.userAgent;
      
      // Needed for the loading screen
      $rootScope.$on('$routeChangeStart', function(){
        $rootScope.loading = true;
      });

      $rootScope.$on('$routeChangeSuccess', function(){
        $rootScope.loading = false;
      });

      // Fake text i used here and there.
      $rootScope.lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel explicabo, aliquid eaque soluta nihil eligendi adipisci error, illum corrupti nam fuga omnis quod quaerat mollitia expedita impedit dolores ipsam. Obcaecati.';

      // 
      // 'Scroll' screen
      // 
      var scrollItems = [];

      for (var i=1; i<=100; i++) {
        scrollItems.push('Item ' + i);
      }

      $rootScope.scrollItems = scrollItems;

      

});

phpuserauth.factory('appSession', function($http){
    return {
        updateNewTask: function(name, detail, deadLine) {
          return $http.post('server/updateTask.php',{
            type    : 'newTask',
            taskName  : name,
            taskDetail  : detail,
            deadLine  : deadLine
          });
        },
        registerUser: function(user_name, first_name, last_name, email, dob, password, verify_password) {
          return $http.post('server/updateTask.php',{
            type      : 'registerUser',
            userName  : user_name,
            firstName : first_name,
            lastName  : last_name,
            email     : email, 
            dob       : dob,
            password  : password,
            verifyPassword: verify_password
          });
        }
    }
});

phpuserauth.config(function($stateProvider, $urlRouterProvider) {

  // Now set up the states
  $stateProvider
    .state('home', {
      url: "/",
      templateUrl: "partials/home.html",
      controller: 'appHomeController',
    })
    .state('login', {
      url: "/login",
      templateUrl: "partials/login.html",
      controller: 'appLoginController',
    })
    .state('register', {
      url: "/register",
      templateUrl: "partials/register.html",
      controller: 'appRegisterController',
    })
    .state('404', {
      url: "/404",
      templateUrl: "404.html",
      controller: 'app404Controller',
    })
    // For any unmatched url, redirect to /state1
     $urlRouterProvider.otherwise("/");

});

phpuserauth.controller('appLoginController', function($scope, $timeout, $rootScope, appSession){
    
  $scope.login = function() {
    alert('You submitted the login form');
  };

  $scope.updateTasks= function(data, status){
      if(data["status"] == 0)
        console.log("Success");
      else
        console.log(data["message"]);
  };
  $scope.displayError = function(data, status){
      console.log("Error");
  };

  init();
  function init(){
      appSession.updateNewTask().success($scope.updateTasks).error($scope.displayError);
  };

});

phpuserauth.controller('appRegisterController', function($scope, $timeout, $rootScope, md5, appSession){
    
  $scope.user_name;
  $scope.first_name;
  $scope.last_name;
  $scope.dob;
  $scope.email;
  $scope.password;
  $scope.verify_password;

  $scope.register = function() {
      appSession.registerUser($scope.user_name, $scope.first_name, $scope.last_name, $scope.email, $scope.dob, md5.createHash($scope.password), md5.createHash($scope.verify_password)).success($scope.updateTasks).error($scope.displayError);
  };

  $scope.updateTasks= function(data, status){
      if(data["status"] == 0)
        console.log("Success");
      else
        console.log(data["message"]);
  };
  $scope.displayError = function(data, status){
      console.log("Error");
  };

  init();
  function init(){
      appSession.updateNewTask().success($scope.updateTasks).error($scope.displayError);
  };

});

phpuserauth.controller('appHomeController', function($scope, $timeout, $rootScope, appSession){

  $scope.updateTasks= function(data, status){
      if(data["status"] == 0)
        console.log("Success");
      else
        console.log(data["message"]);
  };
  $scope.displayError = function(data, status){
      console.log("Error");
  };

  init();
  function init(){
      appSession.updateNewTask().success($scope.updateTasks).error($scope.displayError);
  };

});

phpuserauth.controller('app404Controller', function($scope){

});

//Main Controller for body, handles loading and unloading along with preloader gif
phpuserauth.controller('MainController', function($rootScope, $scope){

  // User agent displayed in home page
  $scope.userAgent = navigator.userAgent;
  
  // Needed for the loading screen
  $rootScope.$on('$routeChangeStart', function(){
    $rootScope.loading = true;
  });

  $rootScope.$on('$routeChangeSuccess', function(){
    $rootScope.loading = false;
  });

  // Fake text i used here and there.
  $rootScope.lorem = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel explicabo, aliquid eaque soluta nihil eligendi adipisci error, illum corrupti nam fuga omnis quod quaerat mollitia expedita impedit dolores ipsam. Obcaecati.';

  // 
  // 'Scroll' screen
  // 
  var scrollItems = [];

  for (var i=1; i<=100; i++) {
    scrollItems.push('Item ' + i);
  }

  $scope.scrollItems = scrollItems;

  $scope.bottomReached = function() {
    alert('Congrats you scrolled to the end of the list!');
  }
  
  // 'Forms' screen
  //  
  $scope.rememberMe = true;
  $scope.email = 'me@example.com';
  
  $scope.login = function() {
    alert('You submitted the login form');
  };

  // 
  // 'Drag' screen
  // 
  $scope.notices = [];
  

  $scope.deleteNotice = function(notice) {
    var index = $scope.notices.indexOf(notice);
    if (index > -1) {
      $scope.notices.splice(index, 1);
    }
  };
});
