<?php
class LivesController extends AppController {

	public $uses = array('Live');  // 指定しなければ Life になる

	public function index() {
		// livesテーブルを取得
		$options = array('recursive' => 0);
		$lives = $this->Live->find('all', $options);
		debug($lives);
		$this->set('lives', $lives);
		$this->render('index');
	}

}
