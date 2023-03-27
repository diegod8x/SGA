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
	<p>Estimado(a), el trabajador <?php echo strtok($datos["Trabajadore"]["nombre"], " ") . " " . $datos["Trabajadore"]["apellido_paterno"]  ?>, ha ingresado comentarios a la siguiente actividad:</p>

	<h4>Comentarios</h4>
	<p><?php echo (isset($datos["Actividade"]["comentarios"])) ? $datos["Actividade"]["comentarios"] : '-' ?></p>

	<h4>Actividad</h4>
	<table cellpadding="5">
		<tr>
			<th align="right">Estado</th>
			<td>&ensp;<?php echo (isset($datos["EstadoActividade"]["nombre"])) ? $datos["EstadoActividade"]["nombre"] : '-' ?></td>
		</tr>
		<tr>
			<th align="right">Tipo Actividad</th>
			<td>&ensp;<?php echo (isset($datos["TipoActividade"]["nombre"])) ? $datos["TipoActividade"]["nombre"] : '-' ?></td>
		</tr>
		<tr>
			<th align="right">Observaciones</th>
			<td>&ensp;<?php echo (isset($datos["Actividade"]["observaciones"])) ? $datos["Actividade"]["observaciones"] : '-' ?></td>
		</tr>
		<tr>
			<th align="right">Dirección</th>
			<td>&ensp;<?php echo (isset($datos["Actividade"]["direccion"])) ? $datos["Actividade"]["direccion"] : '-' ?></td>
		</tr>
		<tr>
			<th>Fecha Actividad</th>
			<td>&ensp;<?php echo (isset($datos["Actividade"]["fecha_ingreso"])) ? DateTime::createFromFormat('Y-m-d', $datos["Actividade"]["fecha_ingreso"])->format('d-m-Y') : '-' ?></td>
		</tr>
		<tr>
			<th align="right">Rango de Entrega</th>
			<td>&ensp;<?php echo (isset($datos["Actividade"]["rango_entrega"])) ? $datos["Actividade"]["rango_entrega"] : '-' ?></td>
		</tr>
		<!--<tr>
			<th align="right">Hora Acordada</th>
			<td>&ensp;<?php echo (isset($datos["Actividade"]["hora_ingreso"])) ? substr($datos["Actividade"]["hora_ingreso"], 0, -3) : '-' ?></td>
		</tr> -->
		<!--<tr>
			<th align="right">GPS</th>
			<td>&ensp;<?php echo (isset($datos["Actividade"]["gps"])) ? $datos["Actividade"]["gps"] : '-' ?></td>
			<td>
				<?php if (isset($datos["Actividade"]["gps"])) { ?>
					&ensp;<a href='http://maps.google.es/?q=<?php echo $datos["Actividade"]["gps"]; ?>'><?php echo $datos["Actividade"]["gps"]; ?></a>
				<?php } else { ?>
					-
				<?php } ?>
			</td>
		</tr> -->
		<tr>
			<th align="right">Cliente</th>
			<td>&ensp;<?php echo (isset($datos["Cliente"]["nombre"])) ? $datos["Cliente"]["nombre"] : '-' ?></td>
		</tr>
		<tr>
			<th align="right">Teléfono Cliente</th>
			<td>&ensp;<?php echo (isset($datos["Cliente"]["telefono"])) ? $datos["Cliente"]["telefono"] : '-' ?></td>
		</tr>
	</table>
	<br><br>Atte.</p>
	<p>&nbsp;</p>
	<h4><a href="http://www.camas.cl/SGA/">Acceder a SGA</a></h4>
</body>

</html>