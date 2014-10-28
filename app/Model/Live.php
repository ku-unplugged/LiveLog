<?php
class Live extends AppModel {

	public $hasMany = array('Song' => array(
		'foreignKey' => 'live_id' // 指定しなければ life_id になる
	));
	public $order = 'Live.date DESC';

}
