app.controller('ComprasReportes', ['$scope', 'listaRoles', '$http', '$filter', '$location', 'uiGridConstants', 'Flash', 'rolesFactory','i18nService', function ($scope, listaRoles, $http, $filter, $location, uiGridConstants, Flash, rolesFactory,i18nService) {
    $scope.tablaDetalle = false;
    $scope.loader = true
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
        {name:'Id', displayName:'Id', visible: true, sort : {direction: uiGridConstants.ASC,priority: 1}},
        //{name:'Id', displayName:'Id', width: '10%'},
        {name:'Nombre', displayName:'Nombre', width: '90%'}
    ];
    listaRoles.listaRoles().success(function(data){
		$scope.gridOptions.data = rolesFactory.rolesActivos(data);
        $scope.loader = false;
        $scope.tablaDetalle = true;
         $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
         	if(row.isSelected == true)
         	{
         		$scope.id = row.entity.Id;
         		$scope.boton = true;
         	}
         	else
         	{
         		$scope.id = "";
         		$scope.boton = false;
         	}
            console.log($scope.boton);
         	
         });
         
         
        $scope.refreshData = function (termObj){
            $scope.gridOptions.data = rolesFactory.rolesActivos(data);
            while (termObj){
                var oSearchArray = termObj.split(' ');
                $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                oSearchArray.shift();
                termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
            }
        };
	});

    $scope.confirmacion = function(){
        listaRoles.delete($scope.id).success(function (data){
            if(data.estado == 1 ){
                 Flash.create('success', data.mensaje, 'customAlert');
                 listaRoles.listaRoles().success(function(data){
                    $scope.gridOptions.data = rolesFactory.rolesActivos(data);
                    $scope.gridApi.selection.clearSelectedRows();
                 });
            }else{
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
}]);