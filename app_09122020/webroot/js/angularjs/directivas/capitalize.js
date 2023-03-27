app.directive('capitalizeFirst', function (uppercaseFilter, $parse) {
    return {
        require: 'ngModel',
        scope: { ngModel: "=" },
        link: function (scope, element, attrs, modelCtrl) {
            scope.$watch("ngModel", function () {
            	if(angular.isDefined(scope.ngModel)){
                    scope.ngModel = scope.ngModel.toLowerCase();
                	scope.ngModel = scope.ngModel.replace(/^(.)|\s(.)/g, function(v){ return v.toUpperCase( ); });
                }
            });
        }
    };
});