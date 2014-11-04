<?php
class SongsController extends AppController {

	public $uses = array('Song', 'Live', 'Member');

	public $components = array('Search.Prg');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

	public function index() {
		if ($this->request->is('get')) {
			$this->Prg->commonProcess();
			$this->paginate = array(
				'conditions' => $this->Song->parseCriteria($this->passedArgs),
				'limit' => 20,
				'order' => array(
					'Live.date' => 'DESC',
					'Song.time' => 'ASC',
					'Song.order' => 'ASC'
				)
			);
			$this->set('songs', $this->paginate());
		}
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			// そのままではメンバーを追加できないのでMembersSongモデルをhasManyする
			$this->Song->bindModel(array('hasMany' => array('MembersSong')));
			if ($this->Song->saveAssociated($this->request->data)) {
				$this->Session->setFlash('<strong>追加しました。</strong>（ID: ' . $this->Song->id . '）', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				$this->request->data = array();
			} else {
				$this->Session->setFlash('<strong>追加に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
		$members = $this->Member->find('list', array('order' => array('Member.year DESC', 'Member.furigana')));
		$lives = $this->Live->find('list');
		$this->set('members', $members);
		$this->set('lives', $lives);
	}

	public function admin_add_nf() {
		$this->admin_add();
	}

	public function admin_edit($id = null) {
		if (!$this->Song->exists($id)) {
			throw new NotFoundException(__('不正なソングIDです。'));
		}
		$this->Song->unbindModel(array('hasAndBelongsToMany' => array('Member')));
		$this->Song->bindModel(array('hasMany' => array('MembersSong')), false);
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Song->saveAssociated($this->request->data)) {
				$this->Session->setFlash('<strong>更新しました。</strong>', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
			} else {
				$this->Session->setFlash('<strong>更新に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		} else {
			$options = array('conditions' => array('Song.id' => $id));
			$this->request->data = $this->Song->find('first', $options);
		}
		$members = $this->Member->find('list', array('order' => array('Member.year DESC', 'Member.furigana')));
		$lives = $this->Live->find('list');
		$this->set('members', $members);
		$this->set('lives', $lives);
	}

	public function admin_delete($id = null) {
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException('不正なIDです');
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->request->is(array('post', 'delete'))) {
			if ($this->Song->delete()) {
				$this->Session->setFlash('<strong>削除しました。</strong>', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
			} else {
				$this->Session->setFlash('<strong>削除に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
		return $this->redirect(array('admin' => false, 'action' => 'index'));
	}

	public function admin_add_nf_csv() {
		if ($this->request->is('post')) {
			setlocale(LC_ALL, 'ja_JP.UTF-8');

			$data = file_get_contents($this->request->data['CSV']['csv']['tmp_name']);
			$data = mb_convert_encoding($data, 'UTF-8', 'sjis-win');
			$data = ereg_replace("\r\n|\r|\n","\n", $data);
			$temp = tmpfile();
			$csv = array();

			fwrite($temp, $data);
			rewind($temp);

			$i = 0;
			while (($data = fgetcsv($temp)) !== FALSE) {
				$csv[$i]['Song']['live_id'] = $this->request->data['CSV']['live'];
				$csv[$i]['Song']['time'] = $data[0];
				$csv[$i]['Song']['order'] = $data[1];
				$csv[$i]['Song']['name'] = $data[2];
				$csv[$i]['Song']['artist'] = $data[3];
				$members = explode(',', $data[4]);
				$j = 0;
				foreach ($members as $member) {
					$inst_name = explode('.', $member);
					if (strpos($inst_name[0], '&')) {
						$inst = explode('&', $inst_name[0]);
						$csv[$i]['MembersSong'][$j]['instrument'] = $inst[0];
						$csv[$i]['MembersSong'][$j]['sub_instrument'] = $inst[1];
					} else {
						$csv[$i]['MembersSong'][$j]['instrument'] = $inst_name[0];
					}
					if (strpos($inst_name[1], '-')) {
						$name = explode('-', $inst_name[1]);
						$member_id = $this->Member->find('first', array(
							'conditions' => array(
								'Member.last_name' => $name[0],
								'Member.first_name LIKE' => $name[1].'%',
								'Member.year <' => '2013'
							)
						));
					} else {
						$member_id = $this->Member->find('first', array(
							'conditions' => array(
								'Member.last_name' => $inst_name[1],
								'Member.year <' => '2013'
							)
						));
					}
					$csv[$i]['MembersSong'][$j]['member_id'] = $member_id['Member']['id'];
					$j++;
				}
				$i++;
			}

			fclose($temp);

			// $this->Song->bindModel(array('hasMany' => array('MembersSong')));
			// if ($this->Song->saveMany($csv, array('deep' => true))) {
			// 	$this->Session->setFlash('<strong>追加しました。</strong>（ID: ' . $this->Song->id . '）', 'alert', array(
			// 		'plugin' => 'BoostCake',
			// 		'class' => 'alert-success'
			// 	));
			// 	$this->request->data = array();
			// } else {
			// 	$this->Session->setFlash('<strong>追加に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
			// 		'plugin' => 'BoostCake',
			// 		'class' => 'alert-danger'
			// 	));
			// }

			debug($csv);
		}
		$lives = $this->Live->find('list');
		$this->set('lives', $lives);
	}

}
