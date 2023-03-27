app.controller('empresasIndex',  ['$scope', '$rootScope','$http', '$filter', '$location', 'uiGridConstants','i18nService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants,i18nService) {
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
        exporterCsvFilename: 'listado_empresas.csv',
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'id', visible: false , minWidth:110},                       
        {name:'rut', displayName:'Rut Empresa', minWidth:110},
        {name:'nombre', displayName:'Nombre Empresa', minWidth:140},
        {name:'direccion', displayName:'Dirección', minWidth:110},
        {name:'telefono', displayName:'Teléfono', minWidth:110},        
        {name:'email', displayName:'Email', visible: false, minWidth:110},        
        {name:'nombre_contacto', displayName:'Contacto', minWidth:110},
        {name:'telefono_contacto', displayName:'Teléfono Contacto', minWidth:120},
    ];

    $http.get(host+'empresas/listado_empresas').success(function(data) {

        console.log(data);

        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data;
       
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

            if(angular.isDefined(row.entity.id))
            {
                
                //if(row.entity.estado_id == 5 || row.entity.estado_id == 6){
                    $scope.btnempresasadd = false;
                    $scope.btnempresasedit = false;
                    $scope.boton = true;
                    $scope.id = row.entity.id;

                //}else{
                /*    $scope.btnevaluaciones_trabajadorescalibrar_edit = true;
                    $scope.btnevaluaciones_trabajadoresadd = true;
                    $scope.btnevaluaciones_trabajadoresedit = false;
                    $scope.boton = true;
                    $scope.id = row.entity.evaluacion_id;*/
                //}

            }
            /*else 
            {
                console.log(row.entity.estado_id);

                $scope.btnevaluaciones_trabajadorescalibrar_edit = true;
                $scope.btnevaluaciones_trabajadoresadd = false;
                $scope.btnevaluaciones_trabajadoresedit = true;
                $scope.boton = true;
                $scope.id = row.entity.trabajador_id;
            }*/

            if(row.isSelected == true)
            {
                /*if(row.entity.IdTipoCompania==1)
                {
                    $scope.operadores = true;
                    $scope.toolContactos = true;
                    $scope.toolOtros = true;
                }
                else
                {
                    $scope.operadores = false;
                    $scope.toolOtros = true;
                    $scope.toolContactos = true;
                }*/
            }
            else
            {
                /*$scope.toolOtros = false;
                $scope.id = "";
                $scope.toolOperadores = false;
                $scope.toolContactos = false;
                $scope.boton = false;
                $scope.operadores = false;*/
            }
            /**/
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


app.controller('empresasAdd', function ($scope, $http, empresasService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, RutHelper) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formEmpresas = false;

	$scope.obtRegiones = function(){
        $scope.formulario = {};
    	serviciosService.getRegiones().success(function (data){
            $scope.regiones = data;
            $scope.loader = false;
            $scope.formEmpresas = true;
        });
   	};
    $scope.obtComunas = function(id){        
        if(angular.isDefined(id)){
            serviciosService.getComunas(id).success(function (data){            
                $scope.comunas = data;
            });            
        }else{
            $scope.comunas = undefined;
            $scope.formulario.Empresa.comuna_id = undefined;
        }
    };
    $scope.registrarEmpresa = function(){
        $scope.deshabilita = true;
        $scope.formulario.Empresa.rut = RutHelper.format($scope.formulario.Empresa.rut);   
    	empresasService.registrarEmpresa($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'empresas';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
   	};
    $scope.validaRut = function(){
        if(angular.isDefined($scope.formulario.Empresa.rut)){
            $scope.formulario.Empresa.rut = RutHelper.format($scope.formulario.Empresa.rut);                             
                serviciosService.validaRut('Empresa', $scope.formulario.Empresa.rut).success(function (data){                    
                    if(data.estado==1){
                        angular.element("#empresasRut").focus();
                        $scope.formulario.Empresa.rut = undefined;
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }
                });                
        }
    };
});

app.controller('empresasEdit', function ($scope, $http, empresasService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, RutHelper) {
    console.log("asdasdas", $scope.formulario)
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formEmpresas = false;
    $scope.formulario = [];
    var rutOriginal;
    $scope.obtDatos = function(idEmpresa){        
        empresasService.getEmpresa(idEmpresa).success(function (data){
            $scope.obtRegiones();
            $scope.obtComunas(data.Regione.id);
            $scope.formulario = data;
            rutOriginal = $scope.formulario.Empresa.rut;
            $scope.loader = false;
            $scope.formEmpresas = true;
        });        
    };
    $scope.obtRegiones = function(){
        serviciosService.getRegiones().success(function (data){
            $scope.regiones = data;
            $scope.loader = false;
            $scope.formEmpresas = true;
        });
    };
    $scope.obtComunas = function(id){        
        if(angular.isDefined(id)){
            serviciosService.getComunas(id).success(function (data){            
                $scope.comunas = data;
            });            
        }else{
            $scope.comunas = undefined;
            $scope.formulario.Empresa.comuna_id = undefined;
        }
    };
    $scope.registrarEmpresa = function(){
        $scope.deshabilita = true;
        console.log($scope.formulario)
        $scope.formulario.Empresa.rut = RutHelper.format($scope.formulario.Empresa.rut);   
        empresasService.registrarEmpresa($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'empresas';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
    };
    $scope.validaRut = function(){
        if(angular.isDefined($scope.formulario.Empresa.rut)){
            $scope.formulario.Empresa.rut = RutHelper.format($scope.formulario.Empresa.rut); 
            if($scope.formulario.Empresa.rut!=rutOriginal){                
                serviciosService.validaRut('Empresa', $scope.formulario.Empresa.rut).success(function (data){                    
                    if(data.estado==1){
                        angular.element("#empresasRut").focus();
                        $scope.formulario.Empresa.rut = undefined;
                        Flash.create('danger', data.mensaje, 'customAlert');
                    }
                });    
            }
        }
    };
});


