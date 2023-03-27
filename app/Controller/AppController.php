<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	

	public function beforeFilter() {

		$this->loadModel("User");
		$this->loadModel("PaginasRole");

        if ($this->request->is('post'))
        {
		
			if(!empty($this->data["users"]))
			{				
				$nombreUser = array();
				$nombreUser = $this->User->find("first", array( 
					"conditions" => array(
						"User.usuario"=> $this->data["users"]["usuario"],
						"User.password"=> '*'.strtoupper(sha1(sha1($this->data["users"]["clave"] , true))),
						"User.estado"=> 1
					), 
					"fields"=> "User.nombre",
					"recursive"=> -1 ));
				
				if(!empty($nombreUser)){
					$this->Session->write('Users', 
						array( 
							"nombre" =>$nombreUser["User"]["nombre"], 
							'usuario'=>$this->data["users"]["usuario"], 
							'flag' => 1
						)
					);
				}
			    else{

			    	$this->Session->write('Users', array(
			    		'flag' => 0
			    		)
					);
					
				}
			
			}
		}

		if($this->Session->read('Users.flag') == 1 )
		{
			if($this->Session->read("Acceso") != NULL)
			{
				foreach($this->Session->read("Acceso") as $accesos)
				{
					if($accesos["controlador"] == $this->params->params["controller"] && $accesos["accion"] == $this->params->params["action"])
					{
						$permisoPagina = 1;
						$this->Session->write('Accesos', array("accesoPagina" => 1));
					}
				}	
			}

			$rolesUsers = $this->User->find("first", array(
				"conditions"=>array("User.usuario"=>$this->Session->read("Users.usuario")),
				"fields"=>"User.role_id",
				"recursive"=>-1
			));
			
			//pr($rolesUsers);
				
			if(!empty($rolesUsers))
			{

				$idRoles = explode(",", $rolesUsers["User"]["role_id"]);
				//$this->loadModel("PaginasBotone");
				

				if(!empty($idRoles))
				{
					$botonesPaginas = array();
					$botonesPaginas = $this->PaginasRole->find("all", array(
						"conditions"=>array("PaginasRole.role_id"=>$idRoles, "Pagina.menu_id"=>8),
						"recursive"=> 0
					));
					$botones = array();  
					$acciones = array();

					//pr($botonesPaginas);
					foreach($botonesPaginas as $botonesPaginas)
					{
						
						$botones[$botonesPaginas["Pagina"]["controlador"]][$botonesPaginas["Pagina"]["ejecucion_metodo"]][$botonesPaginas["Pagina"]["id"]] = array(
							"descripcion"=>$botonesPaginas["Pagina"]["alias"],
							"boton_controller"=>$botonesPaginas["Pagina"]["ejecucion_boton_controlador"],
							"boton_metodo"=>$botonesPaginas["Pagina"]["ejecucion_boton_metodo"],
							"boton_ruta"=>$botonesPaginas["Pagina"]["ejecucion_boton_ruta"],
							);
						$acciones[] = ($botonesPaginas["Pagina"]["accion"]);
					}
					$estilos = array();
					$accionesbotones = array();
					if(!empty($acciones))
					{
						foreach($acciones as $accion)
						{
							$accionesbotones[] = $accion;
						}

						$this->loadModel("PaginasBotonesEstilo");
						
						$estilos = $this->PaginasBotonesEstilo->find("all", array(
							"conditions"=>array("PaginasBotonesEstilo.accion"=>$accionesbotones)
						));

						$estilosBotones = array();

						foreach($estilos as $estilo)
						{
							$estilosBotones[$estilo["PaginasBotonesEstilo"]["accion"]] = array(
								"clase"=>$estilo["PaginasBotonesEstilo"]["clase"],
								"icono"=>$estilo["PaginasBotonesEstilo"]["icono"]
							);							
						}
					}
					if(isset($botones[$this->params->controller])){
						$this->set("botones", $botones[$this->params->controller]);
						$this->set("estilosBotones", $estilosBotones);
					}
				}
			}
			
			if(empty($permisoPagina))
			{
				$this->Session->write('Accesos', array("accesoPagina" => 0));

			}
		}
    }

    public function controlAcceso(){
    	if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
    }
}
