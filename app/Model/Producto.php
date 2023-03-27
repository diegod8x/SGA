<?php
App::uses('AppModel', 'Model');
/**
 * Producto Model
 *
 * @property Contrato $Contrato
 */
class Producto extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Contrato' => array(
			'className' => 'Contrato',
			'joinTable' => 'contratos_productos',
			'foreignKey' => 'producto_id',
			'associationForeignKey' => 'contrato_id',
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
