<?php
App::uses('AppModel', 'Model');
/**
 * FormaPago Model
 *
 * @property Contrato $Contrato
 */
class FormaPago extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'foreignKey' => 'forma_pago_id',
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
