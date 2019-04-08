<!DOCTYPE html>
<html lang="en" ng-app="<?php echo (isset($appAngular) ? $appAngular : "angularApp"); ?>">
<head>
  <meta charset="utf-8">
  <title>camas.cl - SGA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Fav and touch icons -->
  <!--link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png"-->
  <link rel="shortcut icon" href="img/favicon.ico">
    
    <?php echo $this->Html->charset(); ?>
    <title></title>
    <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css(array(
            'bootstrap.min',
          //  'bootstrap-multiselect.css',
            'font-awesome/css/font-awesome.min',
            //'bootstrap-switch.min',
            'select2',
            'select2-bootstrap',
            'datatable',
            'bootstrap-editable',
           // 'summernote-bs3',
            //'PrintArea',
            'angular/ng-grid/ng-grid',
            'angular/ui-grid/ui-grid-unstable',
            'angular/angular-flash/angular-flash.min',
            'angular/select/select.min',
            'angular/ng-table',
            'angular/data-tables/jquery.dataTables.min',
            'style'
            
        ));
        
        echo $this->Html->script(array(
            'angularjs/jquery',
            'bootstrap.min',
            'angularjs/angular.min',
            'angularjs/modulos/ui-grid/ui-grid-unstable.min',
            //'angularjs/modulos/ui-grid/angular-animate',
            'angularjs/modulos/angular-touch',
            'angularjs/modulos/ui-grid/csv',
            'angularjs/modulos/ui-grid/pdfmake',
            'angularjs/modulos/ui-grid/vfs_fonts',
            'angularjs/modulos/sanitize.min',
            'angularjs/angular-locale_es-cl',
            'highcharts.js',            
            'modules/exporting',
            'highcharts-ng.min',
            //'jquery.validate.min',
            'angularjs/modulos/angular-flash/angular-flash.min',
            //'angularjs/modulos/ng-file-upload',
            'angularjs/modulos/select/select.min' ,
           // 'angularjs/modulos/enrutador/angular-route.min',
            //'angularjs/modulos/angular-rut/angular-rut.min',
            "angularjs/modulos/select2/angular-select2.min"
        ));
            
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
    ?>  
</head>

<body>
<?php echo $this->element('cabecera'); ?>
<div class="<?php echo (isset($layoutContent) ? '$layoutContent' : "container"); ?> sombra">
    <?php echo $this->element('miga'); ?>
    <?php echo $this->Session->flash(); ?>
    <div flash-message="5000" ></div> 
    <?php echo $this->fetch('content'); ?>
</div>
<?php echo $this->element('pie'); ?>
<?php echo $this->element('sql_dump'); ?>

</body>
</html>


