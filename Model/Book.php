<?php
App::uses('AppModel', 'Model');
/**
 * Book Model
 *
 * @property Stock $Stock
 * @property User $User
 */
class Book extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';
	public $order = 'Stock.name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Stock' => array(
			'className' => 'Stock',
			'foreignKey' => 'stock_id',
			'conditions' => '',
			//'fields' => 'Stock.name',
			//'order' => array('Stock.name' => 'DESC'),
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
