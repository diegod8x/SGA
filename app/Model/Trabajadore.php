<?php
App::uses('AppModel', 'Model');
/**
 * Trabajadore Model
 *
 * @property Actividade $Actividade
 * @property User $User
 */
class Trabajadore extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Actividade' => array(
			'className' => 'Actividade',
			'foreignKey' => 'trabajadore_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'trabajadore_id',
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

	public $belongsTo = array(
		'EstadoTrabajadore' => array(
			'className' => 'EstadoTrabajadore',
			'foreignKey' => 'estado_trabajadore_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
