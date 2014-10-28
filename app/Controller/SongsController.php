<?php
class SongsController extends AppController {

	public $components = array('Search.Prg');
	public $presetVars = true;

	public function index() {
		if ($this->request->is('post')) {
			$this->Prg->commonProcess();
			// $this->paginate = array(
			// 	'conditions' => $this->Song->parseCriteria($this->passedArgs)
			// );
		}
		$this->set('songs', $this->paginate());
		$this->render('index');
	}

}
