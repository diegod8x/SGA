app.controller('clientesIndex',  ['$scope', '$rootScope','$http', '$filter', '$location', 'uiGridConstants','i18nService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants,i18nService) {
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
        enableGridMenu: true,
        exporterCsvColumnSeparator: ';',
        exporterMenuPdf: false,
        exporterCsvFilename: 'listado_clientes.csv',
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };
    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'id', visible: false , minWidth:110},        
        {name:'rut', displayName:'Rut', minWidth:110},
        {name:'nombre', displayName:'Nombre Cliente', minWidth:130},
        {name:'tipo_contrato', displayName:'Contrato', minWidth:110},        
        {name:'nombre_empresa', displayName:'Empresa', minWidth:110},
        {name:'telefono', displayName:'Teléfono', minWidth:110},
        {name:'email', displayName:'Email', visible: false, minWidth:110},
    ];
    $http.get(host+'clientes/listado_clientes').success(function(data) {
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data;       
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(angular.isDefined(row.entity.id))
            {                
                $scope.btnclientesview = false;
                $scope.btnclientesedit = false;                    
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

app.controller('clientesAdd', function ($scope, $http, clientesService, empresasService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, RutHelper) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formClientes = false;
    var Cliente;
	$scope.obtDatos = function(){
        $scope.formulario = {Cliente:{}};
        promesas = function(){
            empresasService.getEmpresaList().success(function (data){
                $scope.empresas = data;
            });
            serviciosService.getRegiones().success(function (data){
                $scope.regiones = data;
            });
        };
        promesas();
        $scope.loader = false;
        $scope.formClientes = true;        
   	};
    $scope.obtComunas = function(id){        
        if(angular.isDefined(id)){
            serviciosService.getComunas(id).success(function (data){            
                $scope.comunas = data;
            });            
        }else{
            $scope.comunas = undefined;
            $scope.formulario.Cliente.comuna_id = undefined;
        }
    };
    $scope.registrarCliente = function(){    
        $scope.deshabilita = true; 
        $scope.formulario.Cliente.rut = RutHelper.format($scope.formulario.Cliente.rut);   
    	clientesService.registrarCliente($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'clientes';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
   	};
    $scope.validaRut = function(){
        if(angular.isDefined($scope.formulario.Cliente.rut)){
            $scope.formulario.Cliente.rut = RutHelper.format($scope.formulario.Cliente.rut);                             
                serviciosService.validaRut('Cliente', $scope.formulario.Cliente.rut).success(function (data){                    
                    if(data.estado==1){
                        angular.element("#clientesRut").focus();
                        $scope.formulario.Cliente.rut = undefined;
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }
                });
        }
    };
});

app.controller('clientesEdit', function ($scope, $http, clientesService, empresasService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, RutHelper) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formClientes = false;
    var Cliente;
    $scope.formulario = {Cliente:{}};
    var rutOriginal;
    $scope.obtDatos = function(idCliente){        
        clientesService.getCliente(idCliente).success(function (data){
            empresasService.getEmpresaList().success(function (dataEmp){
                $scope.empresas = dataEmp;
            });
            $scope.obtRegiones();
            $scope.obtComunas(data.Regione.id);
            $scope.formulario = data;
            rutOriginal = $scope.formulario.Cliente.rut;
            $scope.loader = false;
            $scope.formClientes = true;            
        });        
    };
    $scope.obtRegiones = function(){
        serviciosService.getRegiones().success(function (data){
            $scope.regiones = data;
            $scope.loader = false;
            $scope.formClientes = true;
        });
    };
    $scope.obtComunas = function(id){        
        if(angular.isDefined(id)){
            serviciosService.getComunas(id).success(function (data){            
                $scope.comunas = data;
            });            
        }else{
            $scope.comunas = undefined;
            $scope.formulario.Cliente.comuna_id = undefined;
        }
    };
    $scope.registrarCliente = function(){
        $scope.deshabilita = true;
        $scope.formulario.Cliente.rut = RutHelper.format($scope.formulario.Cliente.rut);   
        clientesService.registrarCliente($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'clientes';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
    };
    $scope.validaRut = function(){
        if(angular.isDefined($scope.formulario.Cliente.rut)){
            $scope.formulario.Cliente.rut = RutHelper.format($scope.formulario.Cliente.rut); 
            if($scope.formulario.Cliente.rut!=rutOriginal){                
                serviciosService.validaRut('Cliente', $scope.formulario.Cliente.rut).success(function (data){                    
                    if(data.estado==1){
                        angular.element("#clientesRut").focus();
                        $scope.formulario.Cliente.rut = undefined;
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }
                });    
            }
        }
    };
});