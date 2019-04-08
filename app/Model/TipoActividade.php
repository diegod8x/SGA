<?php
App::uses('AppModel', 'Model');
/**
 * TipoActividade Model
 *
 * @property Actividade $Actividade
 */
class TipoActividade extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Actividade' => array(
			'className' => 'Actividade',
			'foreignKey' => 'tipo_actividade_id',
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
