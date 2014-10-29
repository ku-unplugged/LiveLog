<?php
class Song extends AppModel {

	public $actsAs = array('Search.Searchable');

	public $belongsTo = array('Live' => array(
		'foreignKey' => 'live_id' // 指定しなければ life_id になる
	));

	public $hasAndBelongsToMany = array('Member');

	public $filterArgs = array(
		'song_name' => array('type' => 'like', 'field' => 'name'),
		'artist' => array('type' => 'like', 'field' => 'artist')
	);

}
