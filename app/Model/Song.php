<?php
class Song extends AppModel {

	public $belongsTo = array('Live' => array(
		'foreignKey' => 'live_id' // 指定しなければ life_id になる
	));

	public $hasAndBelongsToMany = array('Member');

}
