app.controller('ListaPaginasAsignaPaginas', ['$scope', '$q', "paginasFactory", 'listaPaginas', 'listaPaginasRoles', 'paginasRoles', '$http', '$filter', '$location', 'uiGridConstants','Flash','i18nService',  function ($scope, $q, paginasFactory, listaPaginas, listaPaginasRoles, paginasRoles, $http, $filter, $location, uiGridConstants, Flash,i18nService) {
    
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;
    $scope.langs = i18nService.getAllLangs();
    $scope.lang = 'es';
    angular.element(".tool").tooltip();
    $scope.idRol = $location.absUrl().split("/")
    $scope.idRol = $scope.idRol[$scope.idRol.length - 1];
    $scope.gridOptions = { 
        enableColumnResizing : true,
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
        {name:'Id', displayName:'Id', visible : false},
        {name:'ControladorFantasia', displayName:'Nombre', sort : {direction: uiGridConstants.ASC, priority: 1}, width: '20%'},
        {name:'MenuNombre', displayName:'Menu', width: '15%'},
        {name:'AccionFantasia', displayName:'Accion', width: '20%'},
        {name:'Roles', displayName:'Roles Asoc.', cellTemplate:"<div class='ui-grid-cell-contents'><div data-toggle='tooltip' data-placement='left' title='{{ row.entity.Roles | objectToString:"+'", "'+" }}'>{{ row.entity.Roles | objectToString:', ' }}</div></div>"},
        {name:'Alias', displayName:'Descripción', width: '12%'},
        {field:'Contiene', displayName:'Ok',  width: '5%', cellTemplate:"<div class='ui-grid-cell-contents text-center' ng-if="+'"'+"row['entity']['Roles']["+$scope.idRol+"]!==undefined"+'"'+"><i class='fa fa-check'></i></div>"},
    ];

    asociarPaginas = function (){
        var promesas = [];
        promesas.push(listaPaginas.listaPaginas());
        promesas.push(paginasRoles.paginasRolesList());
        $q.all(promesas).then(function (data){
            datos = paginasFactory.asocPaginasRoles(data[0]["data"], data[1]["data"]);
            $scope.gridOptions.data = datos;
            $scope.loader = false;
            $scope.tablaDetalle = true;

            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                
                if(row.isSelected == true)
                {   
                    $scope.id = row.entity.Id;
                    if(angular.isUndefined(row["entity"]["Roles"][$scope.idRol])){
                        $scope.asignaPaginaRol = true;
                        $scope.quitaPaginaRol = false;
                    }else{
                        $scope.asignaPaginaRol = false;
                        $scope.quitaPaginaRol = true;
                    }
                    
                }
                else
                {
                    $scope.id = "";
                    $scope.boton = false;
                    $scope.asignaPaginaRol = false;
                    $scope.nombreRoles = "";
                }
                console.log(row.isSelected);
             });
             
            $scope.refreshData = function (termObj){
                $scope.gridOptions.data = datos;
                while (termObj){
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        });
    };
    asociarPaginas();
	
	$scope.add = function(){
		if($scope.idRol != "" && $scope.id != "" && angular.isDefined($scope.id)) 
		{
			paginasRoles.add($scope.id, $scope.idRol).success(function(mensaje){
                console.log(mensaje);
				
				if(mensaje.Error === 0)
				{
					Flash.create('danger', mensaje.Mensaje, 'customAlert');
				}
				else
				{
                    asociarPaginas();
                    $scope.gridApi.selection.clearSelectedRows();
                    $scope.search = undefined;
                    $scope.asignaPaginaRol = false;
                    console.log('paso');
                    console.log(mensaje.Mensaje);
					Flash.create('success', mensaje.Mensaje, 'customAlert');
				}
			})
        }
    };

    $scope.delete = function(){
        if($scope.idRol != "" && $scope.id != "" && angular.isDefined($scope.id)) 
        {
            paginasRoles.deleteAsoc($scope.id, $scope.idRol).success(function (data){
                if(data.estado == 1)
                {
                    asociarPaginas();
                    $scope.gridApi.selection.clearSelectedRows();
                    $scope.search = undefined;
                    $scope.quitaPaginaRol = false;
                    Flash.create('success', data.mensaje, 'customAlert');
                }
                else
                {
                    Flash.create('danger', data.mensaje, 'customAlert');                    
                }
            })
        }
    };
}]);

app.controller('ListaPaginasIndex', ['$scope', '$q', "paginasFactory", 'listaPaginas', 'listaPaginasRoles', 'paginasRoles', '$http', '$filter', '$location', 'uiGridConstants','Flash',  function ($scope, $q, paginasFactory, listaPaginas, listaPaginasRoles, paginasRoles, $http, $filter, $location, uiGridConstants, Flash) {
    
    $scope.tablaDetalle = false;
    $scope.loader = true
    $scope.cargador = loader;
    angular.element(".tool").tooltip();
    $scope.idRol = $location.absUrl().split("/")
    $scope.idRol = $scope.idRol[$scope.idRol.length - 1];
    $scope.gridOptions = { 
        enableColumnResizing : true,
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
        {name:'Id', displayName:'Id', visible : false},
       // {name:'FechaCreacion', displayName:'Fecha creación', width: '12%'},
        {name:'ControladorFantasia', displayName:'Nombre', sort : {direction: uiGridConstants.ASC, priority: 1}, width: '20%'},
        {name:'MenuNombre', displayName:'Menu', width: '15%'},
        {name:'AccionFantasia', displayName:'Accion', width: '20%'},
        {name:'Roles', displayName:'Roles Asoc.', cellTemplate:"<div class='ui-grid-cell-contents'><div data-toggle='tooltip' data-placement='left' title='{{ row.entity.Roles | objectToString:"+'", "'+" }}'>{{ row.entity.Roles | objectToString:', ' }}</div></div>"},
    ];

    var promesas = [];
    promesas.push(listaPaginas.listaPaginas());
    promesas.push(paginasRoles.paginasRolesList());
    $q.all(promesas).then(function (data){

        datos = paginasFactory.asocPaginasRoles(data[0]["data"], data[1]["data"]);

        console.log(datos);

        $scope.gridOptions.data = datos;
        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            console.log(row);
            if(row.isSelected == true)
            {   
                console.log(row.isSelected);
                $scope.id = row.entity.Id;
                $scope.boton = true;               
            }
            else
            {
                $scope.id = "";
                $scope.boton = false;
            }
         });
         
        $scope.refreshData = function (termObj){
            $scope.gridOptions.data = datos;
            while (termObj){
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
    });
}]);