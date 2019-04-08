<?php
App::uses('AppModel', 'Model');
/**
 * NumeroCuota Model
 *
 * @property Contrato $Contrato
 */
class NumeroCuota extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'numero_cuota_id',
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
