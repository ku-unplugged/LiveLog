<?php
class Live extends AppModel {

	public $virtualFields = array(
		'name_year' => 'CONCAT(Live.name, " ", DATE_FORMAT(Live.date, "%Y"))'
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
