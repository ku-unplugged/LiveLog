<?php
class Live extends AppModel {

	public $hasMany = array('Song' => array(
		'foreignKey' => 'live_id' // 指定しなければ life_id になる
	));

	public $order = 'Live.date DESC';

	public $validate = array(
		'date' => array(
			'rule' => array('date', 'ymd')
		),
		'name' => array(
			'rule' => array('notEmpty')
		)
	);

}
