<?php
App::uses('AppModel', 'Model');
/**
 * TipoDocumento Model
 *
 * @property Cobranza $Cobranza
 */
class TipoDocumento extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Cobranza' => array(
			'className' => 'Cobranza',
			'foreignKey' => 'tipo_documento_id',
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
