<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Email</title>
</head>
<style>
table, td, th {
    border: 1px solid black;
}

table {
    border-collapse: collapse;
   /* width: 40%;*/
}

th {
    text-align: left;
}
</style>
<body>
	Estimado(a) <?php echo strtok( $datos["Cliente"]["nombre"] , " " ); ?>,
	<p>Dirección: <?php echo $datos["Cliente"]["direccion"]; ?>  <br /> 
	Rut: <?php echo strtok( $datos["Cliente"]["rut"] , " " ); ?><br /> 
    Telefono: <?php echo strtok( $datos["Cliente"]["telefono"] , " " ); ?>
    <br><br>Gracias por preferir nuestro producto y servicio.<br>
	Adjunto la información con desglose de los servicios prestados.</p>

	<p>Nuestra cuenta corriente para futuras transferencias es :<br>
	<b>Cuenta corriente 971 99 63 82<br>
	Scotiabank<br>
	Rut 76.178.129-4<br>
	Conec Company Limitada</b></p>

	<p>Agradeceré informar trasferencia o depósito, con la dirección donde se presta el servicio a <a href="mailto:info@camas.cl" target="_top">info@camas.cl</a> </p>
	<br>
	<p>&nbsp;</p>	
	<div style="text-align:center;margin:0 auto">
		<p ><b>CONTRATO <?php echo strtoupper($datos["TipoContrato"]["nombre"]) ?></b></p><br>
		<table align="center" width="600" style="color:#333333;border-width: 1px; border-color: #3A3A3A;border-collapse: collapse;">
			<tr>
				<th align="right" width="150" style="border-width:1px;padding:8px;border-style:solid;border-color:#3A3A3A;background-color:#B3B3B3;">Nombre</th>
				<td width="150" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;" align="left"><?php echo $datos["Cliente"]["nombre"]; ?></td>								
				<th align="right" width="150" style="border-width:1px;padding:8px;border-style:solid;border-color:#3A3A3A;background-color:#B3B3B3;">Tipo Contrato</th>
				<td style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;" align="left"><?php echo $datos["TipoContrato"]["nombre"]; ?></td>
			</tr>
			<tr>
				<th align="right" style="border-width:1px;padding:8px;border-style:solid;border-color:#3A3A3A;background-color:#B3B3B3;">Fecha Inicio</th>
				<td align="left" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;"><?php echo DateTime::createFromFormat('Y-m-d',$datos["Contrato"]["fecha_inicio"])->format('d-m-Y') ; ?></td>
				<th align="right" style="border-width:1px;padding:8px;border-style:solid;border-color:#3A3A3A;background-color:#B3B3B3;">Día Cobranza</th>
				<td align="left" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;"><?php echo $datos["Contrato"]["fecha_cobro"]; ?></td>
			</tr>
		</table>
		<p>&nbsp;</p>	
		<p><b>Productos</b></p>
		<table width="900" align="center" style="color:#333333;border-width: 1px; border-color: #3A3A3A;border-collapse: collapse;">
			<tr>
				<th align="center" width="300" style="border-width:1px;padding:8px;border-style:solid;border-color:#3A3A3A;background-color:#B3B3B3;">	Nombre </th>
				<th align="center" width="300" style="border-width:1px;padding:8px;border-style:solid;border-color:#3A3A3A;background-color:#B3B3B3;"> Descripción </th>
				<th align="center" style="border-width:1px;padding:8px;border-style:solid;border-color:#3A3A3A;background-color:#B3B3B3;">	Precio $ </th>
			</tr>
			<?php foreach ($datos["Producto"] as $producto) : ?>
			<tr>
				<td align="left" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;"><?php echo $producto["nombre"]; ?></td>
				<td align="left" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;"><?php echo $producto["descripcion"]; ?></td>
				<td align="right" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;"><?php echo ($datos["TipoContrato"]["id"]==1)? number_format($producto["precio_arriendo"],0, '', '.') : number_format($producto["precio_venta"],0, '', '.'); ?></td>
			</tr>	
			<?php endforeach; ?>																
			<tr>
				<th colspan="2" align="right" style="padding: 8px;">	Mensualidad	</th>
				<th align="right" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">$ <?php echo number_format($datos["Contrato"]["subtotal"],0, '', '.'); ?></th>
			</tr>
			<tr>
				<th colspan="2" align="right" style="padding: 8px;">Entrega, instalación y retiro </th>
				<th align="right" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">$ <?php echo number_format($datos["Contrato"]["costo_despacho"],0, '', '.'); ?></th>
			</tr>
			<tr>
				<th colspan="2" align="right" style="padding: 8px;">	Descuentos (-) 	</th>
				<th align="right" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">$ <?php echo number_format($datos["Contrato"]["descuento"],0, '', '.'); ?></th>
			</tr>
			<tr>
				<th colspan="2" align="right" style="padding: 8px;">Precio Total </th>
				<th align="right" style="border-width: 1px;padding: 8px;border-style: solid;border-color: #3A3A3A;background-color: #ffffff;">$ <?php echo number_format($datos["Contrato"]["precio_total"],0, '', '.'); ?></th>
			</tr>
		</table>
		<p>&nbsp;</p>
        <?php
		if ($datos["TipoContrato"]["id"]==1){ ?>
			<table align="center" width="600" style="border-width: 0px; border-collapse: collapse;">
				<tr><td align="center">
            		<strong>Puntos de interés del contrato de arriendo</strong><br>
                    Los pagos se efectuarán el día pactado, con un rango de tolerancia de 5 días.<br>
                    Informar depósito o transferencia mediante correo electrónico a: info@camas.cl, en caso de realizar deposito efectivo o cheque adjuntar fotografía del comprobante.<br>
                    El no pago de la mensualidad, podrá ser motivo de retiro del producto, sin que esto signifique el termino de las obligaciones de pagos pendientes por parte del arrendador.<br>
                    El período de arriendo mínimo es un mes completo a partir del día de entrega, no se realizara reembolso de dinero, independiente que el producto sea usado un día o el primer mes completo.<br>
                    Debe informar mediante llamado telefónico o correo electrónico el retiro del producto.<br>
                    El no pago de las mensualidades adeudadas después del retiro del producto, es motivo de traspaso de la deuda a nuestro Departamento de Cobranza judicial.<br>
                    Se entiende que está de acuerdo con nuestras condiciones de arriendo, de otra manera informar su desconformidad.<br>
            	</td></tr>
			</table>
		<?php }	?>
        
	</div>
	<p>&nbsp;</p>
	<p><b><u>Contacto: info@camas.cl</u></b><br>
	Región Metropolitana 22 8979 109  <br>
	Vina del Mar 32 314 8885  <br>
	Quillota 33 2471 818<br>
	Los Andes 34 2376 250<br>
	Rancagua 72 2743 767<br>
	Celular +5698185048<br>
	Whatsapp +56965996775</p>
	<div style="text-align:left;width:100%">
		<img src="cid:my-unique-id" align="left">
	</div>
</body>
</html>