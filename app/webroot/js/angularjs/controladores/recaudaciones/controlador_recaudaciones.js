app.controller('recaudacionePagos', function ($scope, $http, recaudacioneService , serviciosService, contratosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, i18nService) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formContratos = false;
    var Recaudacione;
    $scope.formulario = {Recaudacione:{}};
    $scope.RecaudacioneOriginal;

    $scope.langs = i18nService.getAllLangs();
    $scope.lang = 'es';
    $scope.gridOptions = {
        enableCellEdit: true,
        enableCellEditOnFocus: true,
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
        exporterCsvFilename: 'pagos_pendientes.csv',
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        rowTemplate: '<div><div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',
        /*onRegisterApi: function(gridApi){
            $scope.gridApi = gridApi;
            gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {
              $scope.msg.lastCellEdited = 'edited row id:' + rowEntity.id + ' Column:' + colDef.name + ' newValue:' + newValue + ' oldValue:' + oldValue;
              $scope.$apply();
            });
          }*/
    };
    /* $scope.gridOptions = {
        enableCellEditOnFocus: true,
    };*/
    $scope.applyClass = function(grid, row, col, rowRenderIndex, colRenderIndex) {
        if (row.entity.ds_estado =='Pagado') {
            return 'disabledRow';
        }
    }
    $scope.tipoDocumento = [ { id: 1, gender: 'Boleta' },
            { id: 2, gender: 'Factura' },
            { id: 3, gender: 'Recibo' }
        ];

    var numArray = [ { id: 1, tipo_documento_id: 'Boleta' },
            { id: 2, tipo_documento_id: 'Factura' },
            { id: 3, tipo_documento_id: 'Recibo' }
        ];

    $scope.gridOptions.columnDefs = [
        { name: 'contrato_id', displayName: '#', minWidth: 130 ,  enableCellEdit: false, visible:false},
        { name: 'nombre_cliente', displayName: 'Cliente', minWidth: 130,  enableCellEdit: false },
        { name: 'fecha_cobro', displayName: 'Fecha Cobro', minWidth: 110 ,  enableCellEdit: false},
        { name: 'ds_estado', displayName: 'Estado', minWidth: 100 ,  enableCellEdit: false},
        { name: 'subtotal', displayName: 'Mensualidad', minWidth: 110 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.subtotal | number:0}}</div>'},
        { name: 'descuento', displayName: 'Descuento', minWidth: 110 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.descuento | number:0}}</div>'},
        { name: 'garantia', displayName: 'Garantía', minWidth: 110 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.garantia | number:0}}</div>'},
        { name: 'despacho', displayName: 'Despacho', minWidth: 110 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.despacho | number:0}}</div>'},
        { name: 'total_cobrado', displayName: 'Total', minWidth: 110 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.total_cobrado | number:0}}</div>'},
        {   name: 'tipo_documento_id',
            enableCellEdit: true,
            displayName: 'Documento',
            editableCellTemplate: 'ui-grid/dropdownEditor', //<i class="fa fa-edit"></i>
            enableColumnMenu: false,
            cellClass: 'cBlue',
            cellFilter: 'mapGender',
            headerCellClass: 'gridCustomId',
            editDropdownValueLabel: 'tipo_documento_id',
            editDropdownOptionsArray: [ { id: '1', tipo_documento_id: 'Boleta' },
                                        { id: '2', tipo_documento_id: 'Factura' },
                                        { id: '3', tipo_documento_id: 'Recibo' }],
            width: 130
        },
        { name: 'nro_documento', displayName: 'Nº Documento', minWidth: 150, cellClass: 'cBlue',headerCellClass: 'gridCustomId', enableColumnMenu: false},
        { name: 'fecha_pago', displayName: 'Fecha Pago', minWidth: 130,  enableCellEdit: true, type: 'date', cellFilter: 'date: \'yyyy-MM-dd\'' , cellClass: 'cBlue',headerCellClass: 'gridCustomId', enableColumnMenu: false},
        { name: 'comentarios', displayName: 'Comentarios', minWidth: 150, cellClass: 'cBlue',headerCellClass: 'gridCustomId', enableColumnMenu: false},
        { name: 'estado', displayName: 'Pagar',  enableCellEdit: false,cellTemplate: '<input ng-true-value="1" ng-false-value="0" type="checkbox" ng-model="row.entity.estado" ng-checked="row.entity.estado==1" ng-init="(row.entity.estado==1)?estado=true:estado=false;" ng-disabled="estado">' , minWidth: 70}
        ];

    $scope.msg = {};
    $scope.msg2 = 'asdasd';

    $scope.gridOptions.onRegisterApi = function(gridApi) {
        //set gridApi on scope
        $scope.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {
            $scope.msg.lastCellEdited = 'edited row id:' + rowEntity.id + ' Column:' + colDef.name + ' newValue:' + newValue + ' oldValue:' + oldValue;
        });
        //$scope.$apply();
    };


    $scope.obtDatos = function(){
        recaudacioneService.getCobros().success(function (data){
            console.log(data);
            console.log(data.Recaudacione.find(obj=>obj.contrato_id === "2390"))
            var Recaudacione;
            $scope.estado = false;
            $scope.datos = {};
            $scope.formulario = {Recaudacione:{}};
            $scope.formulario.Recaudacione = data.Recaudacione;
            $scope.RecaudacioneOriginal = angular.copy(data.Recaudacione);
            $scope.gridOptions.data = data.Recaudacione;
            $scope.datos.TipoDocumento = data.TipoDocumento;
            $scope.datos.DiasVencimiento = data.DiasVencimiento;
            $scope.cuotas = data.cuotas;
            $scope.loader = false;
            $scope.formPagos = true;
            $scope.showCuotas = false;
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                $scope.btnrecaudacionessave = true;
                if(angular.isDefined(row.entity.id))
                {
                    $scope.btnrecaudacionesview = false;
                }
                else
                {
                    $scope.btnrecaudacionesview = true;
                }
                $scope.id = row.entity.contrato_id;
                if(row.isSelected == true)
                    $scope.boton = true;
                else
                    $scope.boton = false;
            });


            $scope.refreshData = function (termObj) {
                $scope.gridOptions.data = data.Recaudacione;
                while (termObj) {
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        });
    };

    $scope.close = function(dialog){
      angular.element("#"+dialog).modal("hide");
    };

    $scope.open = function(dialog){
      angular.element("#"+dialog).modal("show");
    };

    $scope.registrarPagos = function(){
        $scope.deshabilita = true;
        var modificados = [];

        angular.forEach($scope.formulario.Recaudacione, function(valor, pos){
            if(valor.estado==1){
                $scope.formulario.Recaudacione[pos].total_pagado = Number($scope.formulario.Recaudacione[pos].total_cobrado);
                $scope.formulario.Recaudacione[pos].ds_estado = "Pagado";
            }

            if($scope.formulario.Recaudacione[pos].estado!=$scope.RecaudacioneOriginal[pos].estado || $scope.formulario.Recaudacione[pos].nro_documento!=$scope.RecaudacioneOriginal[pos].nro_documento || $scope.formulario.Recaudacione[pos].fecha_pago!=$scope.RecaudacioneOriginal[pos].fecha_pago
                || $scope.formulario.Recaudacione[pos].comentarios!=$scope.RecaudacioneOriginal[pos].comentarios
                || $scope.formulario.Recaudacione[pos].tipo_documento_id !=$scope.RecaudacioneOriginal[pos].tipo_documento_id
                ){
                var d = new Date($scope.formulario.Recaudacione[pos].fecha_pago);
                var n = d.toISOString();
                $scope.formulario.Recaudacione[pos].fecha_pago = n.slice(0, 10);
                delete $scope.formulario.Recaudacione[pos].created;
                delete $scope.formulario.Recaudacione[pos].modified;
                delete $scope.formulario.Recaudacione[pos].$$hashKey;
                modificados.push($scope.formulario.Recaudacione[pos]);
            }
        });

        $scope.formulario.Recaudacione = modificados;
        console.log("modificados", modificados)

        recaudacioneService.registrarPagos($scope.formulario).success(function(data){

            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'recaudaciones';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.verDetalle = function(idContrato){
        contratosService.getContrato(idContrato).success(function (data){
            $scope.open("detalle");
            $scope.detalle = data.data;
            $scope.detalle.Contrato.fecha_inicio = data.data.Contrato.fecha_inicio.split("-").reverse().join("-");
            $scope.productos = data.listadoProductos;

            if(angular.isDefined($scope.detalle.Contrato.numero_cuota_id)){
                angular.forEach($scope.cuotas, function(numCuota){
                    if( numCuota.id == $scope.detalle.Contrato.numero_cuota_id)
                        $scope.numeroCuota = numCuota.numero;
                });
                $scope.detalle.Contrato.valor_cuota = Math.round( (Number($scope.detalle.Contrato.precio_total) / Number($scope.numeroCuota)) * 100)/100;
            }

            if($scope.detalle.Contrato.tipo_contrato_id == 2){
                $scope.showCuotas = true;
            }else{
                $scope.showCuotas = false;
            }
        });
    };
    $scope.close = function(dialog){
      angular.element("#"+dialog).modal("hide");
    };

    $scope.open = function(dialog){
      angular.element("#"+dialog).modal("show");
    };
})
.filter('mapGender', function() {
    var genderHash = {
        1: 'Boleta',
        2: 'Factura',
        3: 'Recibo'
    };
    return function(input) {
        if (!input){
                return '';
            } else {
                return genderHash[input];
            }
    };
});

/*app.controller('recaudacionePagos', function ($scope, $http, recaudacioneService , serviciosService, contratosService, Flash, $filter, $window, $location, $rootScope, $anchorScroll, i18nService) {
    $scope.loader = true;
    $scope.cargador = loader;
    $scope.formContratos = false;
    var Recaudacione;
    $scope.formulario = {Recaudacione:{}};

    $scope.langs = i18nService.getAllLangs();
    $scope.lang = 'es';
    $scope.gridOptions = {
        enableCellEdit: true,
        enableCellEditOnFocus: true,
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
        exporterCsvFilename: 'pagos_pendientes.csv',
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        rowTemplate: '<div><div ng-repeat="col in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ui-grid-cell></div></div>',

    };

    $scope.applyClass = function(grid, row, col, rowRenderIndex, colRenderIndex) {
        if (row.entity.ds_estado =='Pagado') {
            return 'disabledRow';
        }
    }
    $scope.tipoDocumento = [ { id: 1, gender: 'Boleta' },
            { id: 2, gender: 'Factura' },
            { id: 3, gender: 'Recibo' }
        ];

    var numArray = [ { id: 1, tipo_documento_id: 'Boleta' },
                                        { id: 2, tipo_documento_id: 'Factura' },
                                        { id: 3, tipo_documento_id: 'Recibo' }
                                    ];

    console.log(numArray);

    $scope.gridOptions.columnDefs = [
        { name: 'contrato_id', displayName: '#', width: 130 ,  enableCellEdit: false, visible:false},
        { name: 'nombre_cliente', displayName: 'Cliente', width: 130,  enableCellEdit: false },
        { name: 'fecha_cobro', displayName: 'Fecha Cobro', width: 130 ,  enableCellEdit: false},
        { name: 'ds_estado', displayName: 'Estado', width: 100 ,  enableCellEdit: false},
        { name: 'subtotal', displayName: 'Mensualidad', width: 130 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.subtotal | number:0}}</div>'},
        { name: 'descuento', displayName: 'Descuento', width: 130 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.descuento | number:0}}</div>'},
        { name: 'despacho', displayName: 'Despacho', width: 130 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.despacho | number:0}}</div>'},
        { name: 'total_cobrado', displayName: 'Total', width: 130 ,  enableCellEdit: false, cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.total_cobrado | number:0}}</div>'},
        {   name: 'tipo_documento_id',
            enableCellEdit: true,
            displayName: 'Documento',
            editableCellTemplate: 'ui-grid/dropdownEditor', //<i class="fa fa-edit"></i>
            enableColumnMenu: false,
            cellClass: 'cBlue',
            cellFilter: 'mapGender',
            headerCellClass: 'gridCustomId',
            editDropdownValueLabel: 'tipo_documento_id',
            editDropdownOptionsArray: [ { id: '1', tipo_documento_id: 'Boleta' },
                                        { id: '2', tipo_documento_id: 'Factura' },
                                        { id: '3', tipo_documento_id: 'Recibo' }],
            width: 160
        },
        { name: 'nro_documento', displayName: 'Nº Documento', width: 160, cellClass: 'cBlue',headerCellClass: 'gridCustomId', enableColumnMenu: false},
        { name: 'estado', displayName: 'Pagar',  enableCellEdit: false,cellTemplate: '<input ng-true-value="1" ng-false-value="0" type="checkbox" ng-model="row.entity.estado" ng-checked="row.entity.estado==1" ng-init="(row.entity.estado==1)?estado=true:estado=false;" ng-disabled="estado">' , width: 70}
        ];


    $scope.msg = {};
    $scope.msg2 = 'asdasd';

    $scope.gridOptions.onRegisterApi = function(gridApi) {
        $scope.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope, function(rowEntity, colDef, newValue, oldValue) {
            $scope.msg.lastCellEdited = 'edited row id:' + rowEntity.id + ' Column:' + colDef.name + ' newValue:' + newValue + ' oldValue:' + oldValue;
            $scope.$apply();
        });
    };


    $scope.obtDatos = function(){
        recaudacioneService.getCobros().success(function (data){
            console.log(data);
            var Recaudacione;
            $scope.estado = false;
            $scope.datos = {};
            $scope.formulario = {Recaudacione:{}};
            $scope.formulario.Recaudacione = data.Recaudacione;
            $scope.gridOptions.data = data.Recaudacione;
            $scope.datos.TipoDocumento = data.TipoDocumento;
            $scope.datos.DiasVencimiento = data.DiasVencimiento;
            $scope.cuotas = data.cuotas;
            $scope.loader = false;
            $scope.formPagos = true;
            $scope.showCuotas = false;
            $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
                $scope.btnrecaudacionessave = true;
                if(angular.isDefined(row.entity.id))
                {
                    $scope.btnrecaudacionesview = false;
                }
                else
                {
                    $scope.btnrecaudacionesview = true;
                }
                $scope.id = row.entity.id;
                if(row.isSelected == true)
                    $scope.boton = true;
                else
                    $scope.boton = false;
        });

            $scope.refreshData = function (termObj) {
                $scope.gridOptions.data = data.Recaudacione;
                while (termObj) {
                    var oSearchArray = termObj.split(' ');
                    $scope.gridOptions.data = $filter('filter')($scope.gridOptions.data, oSearchArray[0], undefined);
                    oSearchArray.shift();
                    termObj = (oSearchArray.length !== 0) ? oSearchArray.join(' ') : '';
                }
            };
        });
    };

    $scope.close = function(dialog){
      angular.element("#"+dialog).modal("hide");
    };

    $scope.open = function(dialog){
      angular.element("#"+dialog).modal("show");
    };

    $scope.registrarPagos = function(){
        $scope.deshabilita = true;
        angular.forEach($scope.formulario.Recaudacione, function(valor, pos){
                if(valor.estado==1){
                    var d = new Date();
                    var n = d.toISOString();
                    $scope.formulario.Recaudacione[pos].fecha_pago = n.slice(0, 10);
                    $scope.formulario.Recaudacione[pos].total_pagado = $scope.formulario.Recaudacione[pos].total_cobrado;
                }
            });
        recaudacioneService.registrarPagos($scope.formulario).success(function(data){

            if(data.estado==1){
                Flash.create('success', data.mensaje, 'customAlert');
                $window.location = host+'recaudaciones';
            }else if(data.estado==0){
                Flash.create('danger', data.mensaje, 'customAlert');
            }
        });
    };
    $scope.verDetalle = function(idContrato){
        contratosService.getContrato(idContrato).success(function (data){
            $scope.open("detalle");
            $scope.detalle = data.data;
            $scope.detalle.Contrato.fecha_inicio = data.data.Contrato.fecha_inicio.split("-").reverse().join("-");
            $scope.productos = data.listadoProductos;

            if(angular.isDefined($scope.detalle.Contrato.numero_cuota_id)){
                angular.forEach($scope.cuotas, function(numCuota){
                    if( numCuota.id == $scope.detalle.Contrato.numero_cuota_id)
                        $scope.numeroCuota = numCuota.numero;
                });
                $scope.detalle.Contrato.valor_cuota = Math.round( (Number($scope.detalle.Contrato.precio_total) / Number($scope.numeroCuota)) * 100)/100;
            }

            if($scope.detalle.Contrato.tipo_contrato_id == 2){
                $scope.showCuotas = true;
            }else{
                $scope.showCuotas = false;
            }
        });
    };
    $scope.close = function(dialog){
      angular.element("#"+dialog).modal("hide");
    };

    $scope.open = function(dialog){
      angular.element("#"+dialog).modal("show");
    };
})
.filter('mapGender', function() {
    var genderHash = {
        1: 'Boleta',
        2: 'Factura',
        3: 'Recibo'
    };
    return function(input) {
        if (!input){
                return '';
            } else {
                return genderHash[input];
            }
    };
});
*/
app.controller('recaudacioneHistorico',  ['$scope', '$rootScope','$http', '$filter', '$location', 'uiGridConstants','i18nService', '$log', function ($scope, $rootScope, $http, $filter, $location, uiGridConstants, i18nService, $log) {
    $scope.loader = true;
    $scope.tablaDetalle = false;
    $scope.cargador = loader;
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

        /*exporterPdfDefaultStyle: {fontSize: 9},
        exporterPdfTableStyle: {margin: [30, 30, 30, 30]},
        exporterPdfTableHeaderStyle: {fontSize: 10, bold: true, italics: true, color: 'red'},
        exporterPdfHeader: { text: "Pagos / Cobros", style: 'headerStyle' },
        exporterPdfFooter: function ( currentPage, pageCount ) {
          return { text: currentPage.toString() + ' de ' + pageCount.toString(), style: 'footerStyle' };
        },
        exporterPdfCustomFormatter: function ( docDefinition ) {
          docDefinition.styles.headerStyle = { fontSize: 22, bold: true, alignment: 'center'};
          docDefinition.styles.footerStyle = { fontSize: 10, bold: true, alignment: 'center'};
          return docDefinition;
        },
        exporterPdfOrientation: 'landscape',
        exporterPdfPageSize: 'LETTER',
        exporterPdfMaxGridWidth: 570,*/

        showExpandAllInHeader : false,
        expandableRowTemplate: '<div ui-grid="row.entity.subGridOptions" style="height:120px"></div>',
        expandableRowHeight: 120,
        gridExpandableExpandedAll :false,
        onRegisterApi : function(gridApi){
            $scope.gridApi = gridApi;
            //$scope.$apply();
            $scope.gridApi.expandable.on.rowExpandedStateChanged($scope, function (row) {
                if (row.isExpanded) {
                    row.entity.subGridOptions = {
                    columnDefs: [
                        { field:'comentarios', displayName:'Detalle comentarios', cellTemplate: '<p style="width:400px;max-height:120px;margin:0px">{{grid.getCellValue(row,col)}}</p>'}
                    ]};
                    row.entity.subGridOptions.data = angular.fromJson([{"comentarios":row.entity.comentarios}]);
                }
            });
        },
        exporterCsvFilename: 'historico_pagos.csv',
        exporterCsvLinkElement: angular.element(document.querySelectorAll(".custom-csv-link-location")),
        exporterPdfFilename: 'historico_pagos.pdf'
    };


    $scope.gridOptions.columnDefs = [
        //{name:'id', displayName:'#', width:70},
        {name:'rut', displayName:'Rut', minWidth:110},
        {name:'nombre_cliente', displayName:'Cliente', minWidth:150},
        {name:'tipo_contrato', displayName:'Contrato', minWidth:110},
        {name:'comentarios', displayName:'Comentarios', minWidth:160},
        {name:'fecha_pago', displayName:'Fecha Pago',minWidth:110, enableFiltering: false},
        {name:'subtotal', displayName:'Mensualidad', cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.subtotal | number:0}}</div>', minWidth:110},
        {name:'descuento', displayName:'Descuento -', cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.descuento | number:0}}</div>', minWidth:110},
        {name:'garantia', displayName:'Garantía', cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.garantia | number:0}}</div>', minWidth:110},
        {name:'despacho', displayName:'Despacho', cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.despacho | number:0}}</div>', minWidth:110},
        {name:'total_pagado', displayName:'Pagado', cellTemplate: '<div style="text-align:right;"  class="ngCellText">{{row.entity.total_pagado | number:0}}</div>', minWidth:110},
        {name:'tipo_documento', displayName:'Documento', minWidth:110},
        {name:'nro_documento', displayName:'Nro.', minWidth:110},

        //{name:'fecha_cobro', displayName:'Cobranza',width:110},

    ];

    /*$scope.msg = {};

    $scope.gridOptions.onRegisterApi = function(gridApi){
        $scope.gridApi = gridApi;
        gridApi.edit.on.afterCellEdit($scope,function(rowEntity, colDef, newValue, oldValue){
            $scope.msg.lastCellEdited = {"id": rowEntity.Id, "columna" : colDef.name, "valor": newValue} ;
            $scope.$apply();
        });
    };*/

    $http.get(host+'recaudaciones/listado_historico').success(function(data) {

        console.log(data)

        $scope.loader = false;
        $scope.tablaDetalle = true;
        $scope.gridOptions.data = data;

        $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){

            if(angular.isDefined(row.entity.id))
            {
                if(row.entity.contrato_id == 1 && row.entity.estado == 1){
                    $scope.btncontratosview = false;
                    $scope.btncontratosedit = false;
                    $scope.btncontratosasigna_act = false;
                    $scope.boton = true;
                    $scope.id = row.entity.id +"/"+ row.entity.cliente_id;

                }else{

                    $scope.btncontratosview = false;
                    $scope.btncontratosasigna_act = false;
                    $scope.btncontratosedit = true;
                    $scope.boton = true;
                    $scope.id = row.entity.contrato_id+"/"+ row.entity.cliente_id;
                }
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
