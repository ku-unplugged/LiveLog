<?php
class Song extends AppModel {

	public $actsAs = array('Search.Searchable');

	public $belongsTo = array('Live' => array(
		'foreignKey' => 'live_id' // 指定しなければ life_id になる
	));

	public $hasAndBelongsToMany = array('Member');

	public $filterArgs = array(
		'sname' => array('type' => 'like', 'field' => 'name'),
		'artist' => array('type' => 'like', 'field' => 'artist')
	);

	public $validate = array(
		'live' => array(
			'rule' => array('numeric')
		),
		'order' => array(
			'rule' => array('numeric')
		),
		'time' => array(
			'rule' => array('time')
		),
		'name' => array(
			'rule' => array('notEmpty')
		),
		'artist' => array(
			'rule' => array('notEmpty')
		),
		'url' => array(
			'rule' => array('url'),
			'allowEmpty' => true
		)
	);

}
