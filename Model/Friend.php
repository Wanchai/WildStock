<?php
App::uses('AppModel', 'Model');

class Friend extends AppModel {

    //public $displayField = 'name';

/**
 * hasMany associations
 *
 * @var array
 */
	/*public $hasMAny = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/
    
    public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
    );
}
