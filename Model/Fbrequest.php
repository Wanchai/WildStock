<?php
App::uses('AppModel', 'Model');
/**
 * Fbrequest Model
 *
 * @property User $User
 */
class Fbrequest extends AppModel {

//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ToUser' => array(
			'className' => 'User',
			'foreignKey' => 'touser_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
