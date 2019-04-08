<?php
App::uses('AppModel', 'Model');
/**
 * Contrato Model
 *
 * @property TipoContrato $TipoContrato
 * @property Cliente $Cliente
 * @property FormaPago $FormaPago
 * @property Actividade $Actividade
 * @property Producto $Producto
 */
class Contrato extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'TipoContrato' => array(
			'className' => 'TipoContrato',
			'foreignKey' => 'tipo_contrato_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'NumeroCuota' => array(
			'className' => 'NumeroCuota',
			'foreignKey' => 'numero_cuota_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'FormaPago' => array(
			'className' => 'FormaPago',
			'foreignKey' => 'forma_pago_id',
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
		'Actividade' => array(
			'className' => 'Actividade',
			'foreignKey' => 'contrato_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ContratosProducto' => array(
			'className' => 'ContratosProducto',
			'foreignKey' => 'contrato_id',
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


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Producto' => array(
			'className' => 'Producto',
			'joinTable' => 'contratos_productos',
			'foreignKey' => 'contrato_id',
			'associationForeignKey' => 'producto_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
