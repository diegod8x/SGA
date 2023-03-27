app.controller('productosIndex',  ['$scope', '$rootScope','$http', '$filter', '$location', 'uiGridConstants','i18nService', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, i18nService ) {
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;    
    $scope.lang = 'es';
    $scope.gridOptions = {
        //enableColumnResizing : true,
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
        exporterCsvFilename: 'listado_productos.csv',
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
            //$scope.$apply();
        }
    };

    $scope.gridOptions.columnDefs = [
        {name:'id', displayName:'id', visible: false , minWidth:110},               
        {name:'nombre', displayName:'Nombre Producto', minWidth:140},
        {name:'descripcion', displayName:'Descripción', minWidth:110},
        {name:'existencias', displayName:'Existencias', cellTemplate: '<div style="text-align:center;"  class="ngCellText">{{row.entity.existencias}}</div>',width:120},
        {name:'disponibles', displayName:'Disponibles', cellTemplate: '<div style="text-align:center;"  class="ngCellText">{{row.entity.disponibles}}</div>',width:120},
        {name:'precio_arriendo', displayName:'Precio Arriendo', cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.precio_arriendo | number:0}}</div>', minWidth:110},
        {name:'precio_venta', displayName:'Precio Venta', cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.precio_venta | number:0}}</div>', minWidth:110},
    ];

    $http.get(host+'productos/listado_productos').success(function(data) {

        console.log(data);

        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data;
       
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

            if(angular.isDefined(row.entity.id))
            {
                
                //if(row.entity.estado_id == 5 || row.entity.estado_id == 6){
                    $scope.btnproductosadd = false;
                    $scope.btnproductosedit = false;
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

app.controller('productosAdd', function ($scope, $http, productosService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formProductos = false;
    var Producto;
	$scope.obtDatos = function(){
        $scope.formulario = {Producto:{}};

        promesas = function(){
            serviciosService.getRegiones().success(function (data){
                $scope.regiones = data;
            });
        };

        promesas();
        $scope.loader = false;
        $scope.formProductos = true;        
   	};

    $scope.obtComunas = function(id){        
        if(angular.isDefined(id)){
            serviciosService.getComunas(id).success(function (data){            
                $scope.comunas = data;
            });            
        }else{
            $scope.comunas = undefined;
            $scope.formulario.Producto.comuna_id = undefined;
        }
    };

    $scope.registrarProducto = function(){    
        $scope.deshabilita = true;    
    	productosService.registrarProducto($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'productos';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
   	};
});

app.controller('productosEdit', function ($scope, $http, productosService, serviciosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formProductos = false;
    $scope.formulario = [];

    $scope.obtDatos = function(idProducto){        
        productosService.getProducto(idProducto).success(function (data){

            $scope.formulario = data;
            $scope.loader = false;
            $scope.formProductos = true;

            console.log(data);
        });        
    };

    $scope.registrarProducto = function(){
        $scope.deshabilita = true;
        productosService.registrarProducto($scope.formulario).success(function (data){
            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'productos';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            } 
        });
    };


});


