<?php
App::uses('AppModel', 'Model');
/**
 * Empresa Model
 *
 * @property Comuna $Comuna
 * @property Regione $Regione
 * @property Cliente $Cliente
 */
class Empresa extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'empresa_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
