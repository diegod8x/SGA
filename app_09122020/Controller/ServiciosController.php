<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class ServiciosController extends AppController {

	public function comunas($id)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Comuna");
		$comunas = $this->Comuna->find('all', array(
			'fields' => array('Comuna.id', 'Comuna.nombre'), 
			"conditions" => array("regione_id"=>$id),
			'order'=>'Comuna.nombre ASC')
		);
		$listadoComunas = array();
		foreach($comunas as $comuna)
			$listadoComunas[] = array("id"=>$comuna["Comuna"]["id"], "nombre"=>$comuna["Comuna"]["nombre"]);
		
		$this->set('comunas', $listadoComunas);
	}

	public function regiones()
	{	
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Regione");
		$regiones = $this->Regione->find('all', array(
			'fields' => array('Regione.id', 'Regione.nombre'), 
			'order'=>'Regione.id ASC')
		);
		$listadoRegiones = array();
		foreach($regiones as $region)		
			$listadoRegiones[] = array("id"=>$region["Regione"]["id"], "nombre"=>$region["Regione"]["nombre"]);

		$this->set('regiones', $listadoRegiones);
	}

	public function valida_rut()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$controlador = $this->params->query["controlador"];
		$this->loadModel($controlador);
		$estadoRut = $this->{$controlador}->find('all', array(
			'conditions'=>array($controlador.'.rut'=>$this->params->query["rut"]),
			'fields'=>array($controlador.".rut")
		));
		if(!empty($estadoRut)){
			$respuesta = array(
				"estado"=>1,
				"mensaje"=>"El Rut ya se encuetra ingresado"
				);
		}else{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Rut no ingresado"
				);
		}
		$this->set("respuesta", $respuesta);
	}

}