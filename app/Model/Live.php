<?php
class Live extends AppModel {

	public $virtualFields = array(
		'name_year' => 'CONCAT(DATE_FORMAT(Live.date, "%Y"), " ", Live.name)'
	);

	public $displayField = 'name_year';

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
