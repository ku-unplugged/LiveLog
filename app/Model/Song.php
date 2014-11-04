<?php
class Song extends AppModel {

	public $actsAs = array('Search.Searchable');

	public $belongsTo = array('Live' => array(
		'foreignKey' => 'live_id' // 指定しなければ life_id になる
	));

	public $hasAndBelongsToMany = array('Member' => array(
		'order' => 'MembersSong.id'
	));

	public $filterArgs = array(
		'keyword' => array(
			'type' => 'like',
			'field' => array('Song.name', 'Song.artist')
		)
	);

	public $validate = array(
		'live' => array(
			'rule' => array('numeric')
		),
		'order' => array(
			'rule' => array('numeric')
		),
		'time' => array(
			'rule' => array('time'),
			'allowEmpty' => true
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
