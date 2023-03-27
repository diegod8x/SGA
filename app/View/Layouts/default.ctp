<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>camas.cl - SGA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">

	<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
	<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
	<!--script src="js/less-1.3.3.min.js"></script-->
	<!--append ‘#!watch’ to the browser URL, then refresh the page. -->
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Fav and touch icons -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
  <link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
  <link rel="shortcut icon" href="img/favicon.png">
	
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription = ''; ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
       	//echo $this->Html->meta('icon', $this->Html->url('favicon.png', array("type"=>"image/x-icon")));
		//echo $this->Html->meta('icon', $this->Html->url('/img/favicon.png'));
	
		//echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			'bootstrap.min',
			'bootstrap-multiselect.css',
			'font-awesome/css/font-awesome.min',
			//'bootstrap-switch.min',
			'select2',
			'select2-bootstrap',
			'datatable',
			'bootstrap-editable',
			'summernote-bs3',
			//'PrintArea',
			//'bootstrap-switch.min',
			//'cake.generic',
			'style'
			
		));
		
		echo $this->Html->script(array(
			'jquery.min',
			'bootstrap.min',
			//'bootstrap-multiselect',
			'rut',
			'select2.min',
			'jquery.tables',
			'datatables',
			'datatablespaginacion',
			//'bootstrap-editable.min',
			'scripts',
			//'jquery.mockjax',
			'highcharts.js',
			'modules/data',
			'modules/drilldown',
			'modules/exporting',
			//'jquery.searchable.min',
			//'jquery.bootstrap-growl.min',
			//'funciones/funciones',
			//'accounting.min',
			//'bootstrap-progressbar.min',
			//'jquery.PrintArea',
			//'jquery.maskedinput',
			//'jquery.validate.min',
			//'bootstrap-switch.min'
		));
			
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>	
</head>

<body>
<?php echo $this->element('cabecera'); ?>
<div class="container sombra">
	<?php echo $this->element('miga'); ?>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->fetch('content'); ?>
</div>
<?php echo $this->element('pie'); ?>
<?php echo $this->element('sql_dump'); ?>
</body>
</html>


