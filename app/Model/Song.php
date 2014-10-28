<?php
class Song extends AppModel {

	public $belongsTo = array('Live' => array(
		'foreignKey' => 'live_id'
	));

	public $hasAndBelonsToMany = array('Member');

}
