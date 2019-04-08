var app = angular.module('angularApp', ['ngAnimate', 'ui.grid', 'ui.grid.selection', 'ui.grid.resizeColumns', 'ui.grid.moveColumns','ui.grid.exporter', 'ui.grid.selection', 'ngSanitize', 'highcharts-ng', 'ui.grid.expandable', 'ui.grid.pinning'/*, 'ngFileUpload'*/, 'flash', 'ui.select', 'ui.grid.edit', 'ui.grid.cellNav', 'platanus.rut', 'rt.select2']);

var appTextEditor = angular.module('angularAppText', ['ngSanitize', 'textAngular', 'angularApp']);

app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded';
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
	$httpProvider.defaults.headers.common['Cache-Control'] = 'no-cache, no-store, must-revalidate';
	$httpProvider.defaults.headers.common['Pragma'] = 'no-cache';
	$httpProvider.defaults.headers.common['Expires'] = '0';  
}]);

var host = "http://www.camas.cl/SGA/";
var postHeader = {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'};
var loader = '<div align="center"><div class="second_circle"><div class="image_back"><div class="first_circle"></div></div></div></div>';


	

