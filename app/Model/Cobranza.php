<?php
App::uses('AppModel', 'Model');
/**
 * Cobranza Model
 *
 * @property ContratosProducto $ContratosProducto
 * @property TipoDocumento $TipoDocumento
 */
class Cobranza extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ContratosProducto' => array(
			'className' => 'ContratosProducto',
			'foreignKey' => 'contratos_producto_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'TipoDocumento' => array(
			'className' => 'TipoDocumento',
			'foreignKey' => 'tipo_documento_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
