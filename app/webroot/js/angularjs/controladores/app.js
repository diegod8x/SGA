var app = angular.module('angularApp', [
	'ui.grid', 
	'ui.grid.selection', 
	'ui.grid.exporter', 
	'ngSanitize', 
	'ui.grid.pinning', 
	'flash', 
	'ui.select', 
	'ui.grid.edit', 
	'ui.grid.cellNav', 
	'rt.select2',
	'ngTouch',
	'ui.grid.expandable',
	'ui.grid.autoResize',
	'ui.grid.resizeColumns',
	'platanus.rut'
	//'ui.grid.autoFitColumns'
	]);
app.config(['$httpProvider', function ($httpProvider) {
    $httpProvider.defaults.headers.put['Content-Type'] = 'application/x-www-form-urlencoded';
	$httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded';
	$httpProvider.defaults.headers.common['Cache-Control'] = 'no-cache, no-store, must-revalidate';
	$httpProvider.defaults.headers.common['Pragma'] = 'no-cache';
	$httpProvider.defaults.headers.common['Expires'] = '0';  
}]);

var host =  window.location.protocol + '//' + window.location.hostname + (window.location.port ? ':' + window.location.port: '') + "/SGA/";
var postHeader = {'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'};
var loader = '<div align="center"><div class="second_circle"><div class="image_back"><div class="first_circle"></div></div></div></div>';