<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>
<body>
	<h2>SISTEMA GESTIÓN DE ARRIENDO</h2>
	<hr>
	<p>Estimado(a) <?php echo strtok( $datos["Trabajadore"]["nombre_completo"] , " " ); ?>, te ha sido asignada una actividad del tipo <?php echo $datos["TipoActividade"]["nombre"]; ?>, con el siguiente detalle:</p>
	<br>

	<h4>Actividad</h4>
	<table cellpadding="5">
		<tr>
			<th align="right">Tipo Actividad</th> 
			<td>&ensp;<?php echo (isset($datos["TipoActividade"]["nombre"]))? $datos["TipoActividade"]["nombre"]:'-' ?></td>
		</tr>
		<tr>
			<th align="right">Observaciones</th> 
			<td>&ensp;<?php echo (isset($datos["Actividade"]["observaciones"]))? $datos["Actividade"]["observaciones"]:'-' ?></td>
		</tr>
		<tr>
			<th align="right">Dirección</th> 
			<td>&ensp;<?php echo (isset($datos["Actividade"]["direccion"]))? $datos["Actividade"]["direccion"]:'-' ?></td>
		</tr>
		<tr>
			<th>Fecha Actividad</th> 
			<td>&ensp;<?php echo (isset($datos["Actividade"]["fecha_ingreso"]))? DateTime::createFromFormat('Y-m-d',$datos["Actividade"]["fecha_ingreso"])->format('d-m-Y'):'-' ?></td>
		</tr>
		<tr>
			<th align="right">Hora Acordada</th> 
			<td>&ensp;<?php echo (isset($datos["Actividade"]["hora_ingreso"]))? substr($datos["Actividade"]["hora_ingreso"],0,-3):'-' ?></td>
		</tr>
		<tr>
			<th align="right">GPS</th> 
			<!--td>&ensp;<?php echo (isset($datos["Actividade"]["gps"]))? $datos["Actividade"]["gps"]:'-' ?></td-->
			<td>
				<?php if(isset($datos["Actividade"]["gps"])){ ?>
					&ensp;<a href='http://maps.google.es/?q=<?php echo $datos["Actividade"]["gps"]; ?>'><?php echo $datos["Actividade"]["gps"]; ?></a>
				<?php }else{ ?>	
					-
				<?php } ?>	
			</td>
		</tr>
		<tr>
			<th align="right">Cliente</th> 
			<td>&ensp;<?php echo (isset($datos["Cliente"]["nombre"]))? $datos["Cliente"]["nombre"]:'-' ?></td>
		</tr>
		<tr>
			<th align="right">Teléfono Cliente</th> 
			<td>&ensp;<?php echo (isset($datos["Cliente"]["telefono"]))? $datos["Cliente"]["telefono"]:'-' ?></td>
		</tr>	
	</table>
	<?php if(!empty($datos["ProductoEntrega"])){ ?>
	<p><b>Detalle productos:</b></p>
	<table style="color:#333333;border-width: 1px; border-color: #3A3A3A;border-collapse: collapse;">
		<tr>
			<th style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">
			</th>
			<th style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">
			Nombre</th>
			<th style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">
			Descripción</th>
		</tr>
		<?php 
			$i = 1;
			foreach ($datos["ProductoEntrega"] as $prod){ ?>			
		<tr>
			<td style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">
				<?php echo $i?>
			</td>
			<td style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">
				<?php echo $prod["nombre"]?>
			</td>
			<td style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">
				<?php echo $prod["descripcion"]?>
			</td>
		</tr>
		<?php 
				$i++; 
			} 
		?>
	</table>
	<?php } ?>
	<br><br>Gracias.</p>
	<p>&nbsp;</p>	
	<h4><a href="http://www.camas.cl/SGA/">Acceder a SGA</a></h4>
</body>
</html>