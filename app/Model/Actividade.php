<?php
App::uses('AppModel', 'Model');
/**
 * Actividade Model
 *
 * @property Contrato $Contrato
 * @property TipoActividade $TipoActividade
 * @property Trabajadore $Trabajadore
 * @property Comuna $Comuna
 * @property Regione $Regione
 */
class Actividade extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'contrato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TipoActividade' => array(
			'className' => 'TipoActividade',
			'foreignKey' => 'tipo_actividade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Trabajadore' => array(
			'className' => 'Trabajadore',
			'foreignKey' => 'trabajadore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Comuna' => array(
			'className' => 'Comuna',
			'foreignKey' => 'comuna_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Regione' => array(
			'className' => 'Regione',
			'foreignKey' => 'regione_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'EstadoActividade' => array(
			'className' => 'EstadoActividade',
			'foreignKey' => 'estado_actividade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
