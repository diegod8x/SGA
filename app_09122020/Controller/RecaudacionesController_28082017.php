<?php
App::uses('AppController', 'Controller');
/**
 * Recaudaciones Controller
 *
 * @property Recaudacione $Recaudacione
 * @property PaginatorComponent $Paginator
 */
class RecaudacionesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index(){
		AppController::controlAcceso();
		$this->layout = "angular";
	}
	public function index_json() {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("TipoDocumento");
		$this->loadModel("TipoContrato");
		$this->loadModel("Condicione");
		$this->loadModel("NumeroCuota");

		$nroCuotas = $this->NumeroCuota->find('all',array(
			"fields"=>array("NumeroCuota.id", "NumeroCuota.numero"),
			"recursive" => -1
			));
		foreach ($nroCuotas as $cuota) {
			$cuotas[] = $cuota["NumeroCuota"];
		}
		$lstPagos = array();
		$tipoContratos = $this->TipoContrato->find("list",array("fields"=>array("TipoContrato.nombre")));
		$diasVencimiento = $this->Condicione->find("list",array("fields"=>array("Condicione.valor_inicio"), "conditions"=>array("Condicione.id"=>1)));

		$listadoPagos = $this->Recaudacione->find("all",array("conditions"=> array("Recaudacione.fecha_cobro <="=> date("Y-m-d")),
			"recursive"=>1));	
		foreach ($listadoPagos as $pago) {
			$vencimiento = date('Y-m-d', strtotime($pago["Recaudacione"]["fecha_cobro"]. ' + '.intval($diasVencimiento[1]).' days'));
			$pago["Recaudacione"]["nombre_cliente"] = $pago["Cliente"]["nombre"];
			$pago["Recaudacione"]["tipo_contrato"] = $tipoContratos[$pago["Contrato"]["tipo_contrato_id"]];
			$pago["Recaudacione"]["tipo_contrato_id"] = $pago["Contrato"]["tipo_contrato_id"];
			$pago["Recaudacione"]["ds_estado"] = ($pago["Recaudacione"]["estado"]==1)?'Pagado':(($vencimiento < date("Y-m-d"))?'Adeudado':'Pendiente');
			$pago["Recaudacione"]["fecha_vencimiento"] = $vencimiento;
			$lstPagos[] = $pago["Recaudacione"];
		}

		$tipoDocumentos = $this->TipoDocumento->find("all",array("recursive"=>-1));	
		foreach ($tipoDocumentos as $value) { $tipoDocumento[] = $value["TipoDocumento"];}

		$respuesta = array_merge(array("Recaudacione"=>$lstPagos),
			array("TipoDocumento"=>$tipoDocumento),
			array("DiasVencimiento"=>intval($diasVencimiento[1])),
			array("cuotas"=>$cuotas)
			);
		$this->set('pagos',$respuesta);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		AppController::controlAcceso();
		if (!$this->Recaudacione->exists($id)) {
			throw new NotFoundException(__('Invalid recaudacione'));
		}
		$options = array('conditions' => array('Recaudacione.' . $this->Recaudacione->primaryKey => $id));
		$this->set('recaudacione', $this->Recaudacione->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		AppController::controlAcceso();
		if ($this->request->is('post')) {
			$this->Recaudacione->create();
			if ($this->Recaudacione->save($this->request->data)) {
				$this->Flash->success(__('The recaudacione has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The recaudacione could not be saved. Please, try again.'));
			}
		}
		$contratos = $this->Recaudacione->Contrato->find('list');
		$clientes = $this->Recaudacione->Cliente->find('list');
		$tipoDocumentos = $this->Recaudacione->TipoDocumento->find('list');
		$this->set(compact('contratos', 'clientes', 'tipoDocumentos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit_json($id = null) {
		if (!$this->Recaudacione->exists($id)) {
			throw new NotFoundException(__('Invalid recaudacione'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Recaudacione->save($this->request->data)) {
				$this->Flash->success(__('The recaudacione has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The recaudacione could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Recaudacione.' . $this->Recaudacione->primaryKey => $id));
			$this->request->data = $this->Recaudacione->find('first', $options);
		}
		$contratos = $this->Recaudacione->Contrato->find('list');
		$clientes = $this->Recaudacione->Cliente->find('list');
		$tipoDocumentos = $this->Recaudacione->TipoDocumento->find('list');
		$this->set(compact('contratos', 'clientes', 'tipoDocumentos'));
	}
/*
	public function registrar_pagos($id = null) {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("Cobranza");
		$conditionsVenta = array();

		if ($this->request->is(array('post', 'put'))) {
			if(!empty($this->request->data)){
				//pr($this->request->data);exit;
				foreach ($this->request->data["Recaudacione"] as $value) {
					if($value["tipo_contrato_id"]==2 && $value["ds_estado"]=='Pagado'){
						$cuotas = $this->Recaudacione->find("all", array(
							"conditions"=> array( "Recaudacione.contrato_id" => $value["contrato_id"],
								"estado" => 0 ),
							"recursive" => -1
							));
						if(count($cuotas)>1){
							$estado = 1;
						}else{
							$estado = 0;
						}
					}
					$contratoDespachos[] = ($value["tipo_contrato_id"]==2)?
						array("id"=>$value["contrato_id"], "estado"=> $estado) //venta se elimina
						:	array("id"=>$value["contrato_id"],"cobrar_despacho"=>0);
				}

				if($this->Recaudacione->saveAll($this->request->data["Recaudacione"])){
					$this->Contrato->saveAll($contratoDespachos);

					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se actualizó correctamente",					
						);				
				} else {
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo registrar, por favor intentelo de nuevo",					
						);
				}
			}
		}
		$this->set("respuesta",$respuesta);
	}*/
	public function registrar_pagos($id = null) {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("Cobranza");
		$conditionsVenta = array();

		if ($this->request->is(array('post', 'put'))) {
			if(!empty($this->request->data)){

				foreach ($this->request->data["Recaudacione"] as $value) {
										
					if($value["tipo_contrato_id"]==2 && $value["ds_estado"]=='Pagado'){
						$cuotas = $this->Recaudacione->find("all", array(
							"conditions"=> array( "Recaudacione.contrato_id" => $value["contrato_id"],
								"estado" => 0 ),
							"recursive" => -1
							));
						if(count($cuotas)>1){
							$estado = 1;
						}else{
							$estado = 0;
						}
					}

					$contratoDespachos[] = ($value["tipo_contrato_id"]==2)?
						array("id"=>$value["contrato_id"], "estado"=> $estado) //venta se elimina
						:	array("id"=>$value["contrato_id"],"cobrar_despacho"=>0);
				}
				
				if($this->Recaudacione->saveAll($this->request->data["Recaudacione"])){
					$this->Contrato->saveAll($contratoDespachos);

					$respuesta = array(
						"estado"=>1,
						"mensaje"=>"Se actualizó correctamente",					
						);				
				} else {
					$respuesta = array(
						"estado"=>0,
						"mensaje"=>"No se pudo registrar, por favor intentelo de nuevo",					
						);
				}
			}
		}
		$this->set("respuesta",$respuesta);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Recaudacione->id = $id;
		if (!$this->Recaudacione->exists()) {
			throw new NotFoundException(__('Invalid recaudacione'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Recaudacione->delete()) {
			$this->Flash->success(__('The recaudacione has been deleted.'));
		} else {
			$this->Flash->error(__('The recaudacione could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	public function add_cobranza() {

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("Recaudacione");
		$this->loadModel("HistoricoPago");
		$this->loadModel("NumeroCuota");

		$listadoContratos = array();		
		$listPagados = array();
		$respuesta=array();

		$timeZome = timezone_open('America/Santiago');
		$date = new DateTime();
		$date->setTimezone($timeZome);		

		$contratos = $this->Contrato->find('all',array(			
			"conditions"=>array("Contrato.fecha_cobro IN"=>array($date->format("d"),$date->format("j")),
				"Contrato.estado" => 1
				),
			"recursive"=> -1
		));

		$pagosDelDia = $this->Recaudacione->find("list",array("fields"=>"Recaudacione.contrato_id","conditions"=>array("Recaudacione.fecha_cobro"=> date("Y-m")."-".$date->format("d") ),"recursive"=>-1));

		if(!empty($contratos)){
			foreach ($contratos as $contrato) {			
				$totalCobrado = $contrato["Contrato"]["subtotal"];
				if($contrato["Contrato"]["cobrar_despacho"]==1)
					$totalCobrado = $totalCobrado + $contrato["Contrato"]["costo_despacho"];
				if($contrato["Contrato"]["cobrar_descuento"]==1)
					$totalCobrado = $totalCobrado - $contrato["Contrato"]["descuento"];
				//cuotas				
				$acumulado = 0;
				$i = 1; 
				$mesCobroCuota = date("Y-m");
				$nroCuotas = $this->NumeroCuota->find("list");	
				if($contrato["Contrato"]["tipo_contrato_id"]==2){					
					for( $i = 1 ; $i < $nroCuotas[$contrato["Contrato"]["numero_cuota_id"]]; $i++){						
						if( ($contrato["Contrato"]["fecha_cobro"] <= $date->format("d") || $contrato["Contrato"]["fecha_cobro"] <= $date->format("j") ) && $i == 1){
							$montoCuota = round($totalCobrado / $nroCuotas[$contrato["Contrato"]["numero_cuota_id"]]);
						}else{							
							$time = strtotime((string) $mesCobroCuota.'-01');
							$mesCobroCuota = date("Y-m", strtotime("+1 month", $time));
							$montoCuota = round($totalCobrado / $nroCuotas[$contrato["Contrato"]["numero_cuota_id"]]);
						}
						$fechaCobroCuota = $mesCobroCuota."-".$contrato["Contrato"]["fecha_cobro"];
						$acumulado = $acumulado + $montoCuota;		

						if (!in_array($contrato["Contrato"]["id"], $pagosDelDia))				
							$listadoContratos[] = array(
								"contrato_id" 			=> $contrato["Contrato"]["id"],
								"cliente_id" 			=> $contrato["Contrato"]["cliente_id"],				
								"fecha_cobro" 			=> $fechaCobroCuota,
								"mes_cobro" 			=> date("Ym", strtotime((string)$fechaCobroCuota)),
								"fecha_pago" 			=> null,
								"estado" 				=> 0,
								"cantidad_productos" 	=> $contrato["Contrato"]["cantidad_productos"],
								"subtotal" 				=> $contrato["Contrato"]["subtotal"],
								"despacho" 				=> ($contrato["Contrato"]["cobrar_despacho"]==1 && $i == 1)?  $contrato["Contrato"]["costo_despacho"]:0,
								"descuento" 			=> ($contrato["Contrato"]["cobrar_descuento"]==1 && $i == 1)? $contrato["Contrato"]["descuento"]:0,
								"total_cobrado"			=> $montoCuota,
								"total_pagado"			=> 0,
								"tipo_documento_id" 	=> null,
								"nro_documento" 		=> null
								);
					}
					//ultima cuota					
					$time = strtotime($mesCobroCuota.'-01');
					if($nroCuotas[$contrato["Contrato"]["numero_cuota_id"]]>1)						
						$mesCobroCuota = date("Y-m", strtotime("+1 month", $time));	
					$fechaCobroCuota = $mesCobroCuota."-".$contrato["Contrato"]["fecha_cobro"];									
					$montoCuota = $totalCobrado - $acumulado;

					if (!in_array($contrato["Contrato"]["id"], $pagosDelDia))
						$listadoContratos[] = array(
							"contrato_id" 			=> $contrato["Contrato"]["id"],
							"cliente_id" 			=> $contrato["Contrato"]["cliente_id"],				
							"fecha_cobro" 			=> $fechaCobroCuota,
							"mes_cobro" 			=> date("Ym", strtotime((string)$fechaCobroCuota)),
							"fecha_pago" 			=> null,
							"estado" 				=> 0,
							"cantidad_productos" 	=> $contrato["Contrato"]["cantidad_productos"],
							"subtotal" 				=> $contrato["Contrato"]["subtotal"],
							"despacho" 				=> ($contrato["Contrato"]["cobrar_despacho"]==1 && $nroCuotas[$contrato["Contrato"]["numero_cuota_id"]]==1)?  $contrato["Contrato"]["costo_despacho"]:0,
							"descuento" 			=> ($contrato["Contrato"]["cobrar_descuento"]==1 && $nroCuotas[$contrato["Contrato"]["numero_cuota_id"]]==1)? $contrato["Contrato"]["descuento"]:0,
							"total_cobrado"			=> $montoCuota,
							"total_pagado"			=> 0,
							"tipo_documento_id" 	=> null,
							"nro_documento" 		=> null
							);
				}else {
					if(!empty($contrato)){
						
						if (!in_array($contrato["Contrato"]["id"], $pagosDelDia))
							$listadoContratos[] = array(
								"contrato_id" 			=> $contrato["Contrato"]["id"],
								"cliente_id" 			=> $contrato["Contrato"]["cliente_id"],				
								"fecha_cobro" 			=> $date->format("Y-m-d"),
								"mes_cobro" 			=> $date->format("Ym"),
								"fecha_pago" 			=> null,
								"estado" 				=> 0,
								"cantidad_productos" 	=> $contrato["Contrato"]["cantidad_productos"],
								"subtotal" 				=> $contrato["Contrato"]["subtotal"],
								"despacho" 				=> ($contrato["Contrato"]["cobrar_despacho"]==1)?  $contrato["Contrato"]["costo_despacho"]:0,
								"descuento" 			=> ($contrato["Contrato"]["cobrar_descuento"]==1)? $contrato["Contrato"]["descuento"]:0,
								"total_cobrado"			=> $totalCobrado,
								"total_pagado"			=> 0,
								"tipo_documento_id" 	=> null,
								"nro_documento" 		=> null
								);
					}
				}
				// fin cuotas				
			}			
		}
		
		/*if(!empty($contratosId)){
			$contratosProductos = $this->ContratosProducto->find('all',array(
				"fields"=> array("ContratosProducto.id","ContratosProducto.contrato_id", "ContratosProducto.precio_arriendo","ContratosProducto.precio_venta"),
				"conditions"=>array( 
					"ContratosProducto.estado" =>1,
					"ContratosProducto.contrato_id"=> $contratosId
					),
				"recursive"=>-1,
				"order"=>"ContratosProducto.contrato_id ASC, ContratosProducto.producto_id ASC"
				));
			foreach ($contratosProductos as $productos) {
				$productosArray[] = array(
					//"tipo_contrato_id"=> $datosContratos[$productos["ContratosProducto"]["contrato_id"]],
					"contratos_id"=>intval($productos["ContratosProducto"]["id"]),
					"monto_cobrado" => ($productos["ContratosProducto"]["precio_arriendo"]>0)? intval($productos["ContratosProducto"]["precio_arriendo"]): intval($productos["ContratosProducto"]["precio_venta"]),
					"monto_pagado" => 0,
					"fecha_cobro" => $date->format("Y-m-d"),
					"mes_cobro" => $date->format("Ym"),
					"estado" => 0);		
			}	 }*/

		//pr($listadoContratos);exit;
		if(!empty($listadoContratos))
			$this->Recaudacione->saveAll($listadoContratos);

		$registrosPagados = $this->Recaudacione->find("all",array("conditions"=>array("Recaudacione.estado"=>1),"recursive"=>-1));
		if(!empty($registrosPagados))
			foreach ($registrosPagados as $pagados) $listPagados[] = $pagados["Recaudacione"];

		if(!empty($listPagados))
			$this->HistoricoPago->saveAll($listPagados);

		$this->Recaudacione->deleteAll(array('Recaudacione.estado' => 1), false);

		$this->set("respuesta",$respuesta);
	}

	public function historico() {
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_historico(){
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("HistoricoPago");
		$this->loadModel("TipoContrato");

		$tipoContratos = $this->TipoContrato->find("list",array("fields"=>array("TipoContrato.nombre")));
		$listadoPagos = $this->HistoricoPago->find("all", array(
			"order"=>"HistoricoPago.id DESC",
			"recursive"=>1
			));		

		$listadoHistorico = array();
		foreach ($listadoPagos as $pago) {			
			$pago["HistoricoPago"]["id"] = intval($pago["HistoricoPago"]["id"]);
			$pago["HistoricoPago"]["subtotal"] = intval($pago["HistoricoPago"]["subtotal"]);
			$pago["HistoricoPago"]["cantidad_productos"] = intval($pago["HistoricoPago"]["cantidad_productos"]);
			$pago["HistoricoPago"]["despacho"] = intval($pago["HistoricoPago"]["despacho"]);
			$pago["HistoricoPago"]["descuento"] = intval($pago["HistoricoPago"]["descuento"]);
			$pago["HistoricoPago"]["total_pagado"] = intval($pago["HistoricoPago"]["total_pagado"]);
			$listadoHistorico[] = array_merge($pago["HistoricoPago"], array(
				"nombre_cliente" => $pago["Cliente"]["nombre"],
				"contrato_id" => intval($pago["HistoricoPago"]["contrato_id"]),
				"tipo_contrato" => $tipoContratos[$pago["Contrato"]["tipo_contrato_id"]],
				"tipo_documento" => $pago["TipoDocumento"]["nombre"],
				 ));			
		}

		$this->set("historicoPago",$listadoHistorico);
	}

}

