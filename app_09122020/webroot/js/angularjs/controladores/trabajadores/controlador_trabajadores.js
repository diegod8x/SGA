app.controller('trabajadoresIndex',  ['$scope', '$rootScope','$http', '$filter', '$location', 'uiGridConstants','i18nService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants,i18nService) {
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;
    $scope.langs = i18nService.getAllLangs();
    $scope.lang = 'es';
    $scope.gridOptions = {
        enableFiltering: false,
        useExternalFiltering: true,
        flatEntityAccess: true,
        showGridFooter: true,
        enableRowSelection: true,
        enableRowHeaderSelection: true,
        multiSelect: false,
        enableSorting: true,
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'id', visible: false },        
        {name:'rut', displayName:'Rut'},
        {name:'nombre_completo', displayName:'Nombre Trabajador'},        
        {name:'email', displayName:'Email'},  
        {name:'telefono', displayName:'Telefono'},
        {name:'estado', displayName:'Estado'},  
    ];
    $http.get(host+'trabajadores/listado_trabajadores').success(function(data) {
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(angular.isDefined(row.entity.id))
            {                
                $scope.btntrabajadoresview = false;
                $scope.btntrabajadoresedit = false;
                $scope.boton = true;
                $scope.id = row.entity.id;
            }
        }); 
        $scope.refreshData = function (termObj) {
            $scope.gridOptions.data = data;
            while (termObj) {
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);
app.controller('trabajadoresAdd', function ($scope, $http, trabajadoresService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, RutHelper) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formTrabajadores = false;
	$scope.obtDatosTrabajadores = function(){
        $scope.loader = false;
        $scope.formTrabajadores = true;        
   	};
    $scope.registrarTrabajadore = function(){   
        $scope.deshabilita = true;            
        $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);
    	trabajadoresService.registrarTrabajadore($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'trabajadores';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
   	};    
    $scope.validaRut = function(){
        if(angular.isDefined($scope.formulario.Trabajadore.rut)){
            $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);                             
                serviciosService.validaRut('Trabajadore', $scope.formulario.Trabajadore.rut).success(function (data){                    
                    if(data.estado==1){
                        angular.element("#trabajadoresRut").focus();
                        $scope.formulario.Trabajadore.rut = undefined;
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }
                });                
        }
    };
});
app.controller('trabajadoresEdit', function ($scope, $http, trabajadoresService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, RutHelper) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formTrabajadores = false;
    $scope.formulario = [];
    var rutOriginal;
    $scope.obtDatosTrabajadores = function(idTrabajador){        
        trabajadoresService.getTrabajadore(idTrabajador).success(function (data){            
            $scope.estados = data.dataEstados;
            $scope.formulario = data;
            rutOriginal = $scope.formulario.Trabajadore.rut;
            $scope.loader = false;
            $scope.formTrabajadores = true;
        });        
    };
    $scope.registrarTrabajadore = function(){
        $scope.deshabilita = true;
        $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut);
        trabajadoresService.registrarTrabajadore($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'trabajadores';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
    };
    $scope.validaRut = function(){
        if(angular.isDefined($scope.formulario.Trabajadore.rut)){
            $scope.formulario.Trabajadore.rut = RutHelper.format($scope.formulario.Trabajadore.rut); 
            if($scope.formulario.Trabajadore.rut!=rutOriginal){                
                serviciosService.validaRut('Trabajadore', $scope.formulario.Trabajadore.rut).success(function (data){                    
                    if(data.estado==1){
                        angular.element("#trabajadoresRut").focus();
                        $scope.formulario.Trabajadore.rut = undefined;
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }
                });    
            }
        }
    };
});