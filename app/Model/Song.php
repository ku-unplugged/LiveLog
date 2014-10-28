<?php
class Song extends AppModel {

	public $belongsTo = array('Live' => array(
		'foreignKey' => 'live_id' // 指定しなければ life_id になる
	));

	public $hasAndBelongsToMany = array('Member');

	public $actAs = array('Search.Searchable');

	public $filterArgs = array(
		'Song.name' => array('type' => 'like'),
		'Song.artist' => array('type' => 'like')
	);

}
