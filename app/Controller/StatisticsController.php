<?php
class StatisticsController extends AppController {

	public $uses = array('Live', 'Member', 'Song', 'MembersSong');

	public function index() {

		$year = isset($this->request->query['year']) ? $this->request->query['year'] : date('Y');

		if ($year === 'all') {
			$condition = '';
		} else {
			$condition = sprintf('AND l.date BETWEEN "%s-04-01" AND "%s-03-31"', $year, (int)($year) + 1);
		}

		// 総曲数
		if ($year === 'all') {
			$options = array();
		} else {
			$options = array('conditions' => array(
				'Live.date BETWEEN ? AND ?' => array($year . '-04-01', ((int)($year) + 1) . '-03-31')
			));
		}
		$song_sum = $this->Song->find('count', $options);
		$this->set('song_sum', $song_sum);

		// 出演数ランキング
		$mem_rank = $this->Member->query(sprintf(
			'SELECT m.id, CONCAT(m.last_name, " ", m.first_name) name, m.nickname, COUNT(*) sum
			FROM lives l, members m, songs s, members_songs ms
			WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
			%s
			GROUP BY m.id
			ORDER BY COUNT(*) DESC
			LIMIT 20',
			$condition
		));
		$this->set('mem_rank', $mem_rank);

		// アーティストランキング
		$art_rank = $this->Song->query(sprintf(
			'SELECT s.artist name, COUNT(*) sum
			FROM lives l, songs s
			WHERE l.id = s.live_id
			%s
			GROUP BY s.artist
			ORDER BY COUNT(*) DESC
			LIMIT 20',
			$condition
		));
		$this->set('art_rank', $art_rank);

		// 構成人数
		$band_num = $this->MembersSong->query(sprintf(
			'SELECT band.num, ROUND(COUNT(*) / %d * 100, 1) AS percent
			FROM (
				SELECT COUNT(*) num
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id AND s.id = ms.song_id
				%s
				GROUP BY ms.song_id
			) band
			GROUP BY band.num',
			$song_sum,
			$condition
		));
		$band_avg_std = $this->MembersSong->query(sprintf(
			'SELECT AVG(band.num) avg, STD(band.num) std
			FROM (
				SELECT ms.song_id, COUNT(*) num
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id AND s.id = ms.song_id
				%s
				GROUP BY ms.song_id
			) band',
			$condition
		));
		$this->set('band_num', $band_num);
		$this->set('band_avg_std', $band_avg_std);

		// 楽器ランキング
		$inst_rank = $this->MembersSong->query(sprintf(
			'SELECT ms.instrument inst, COUNT(*) sum
			FROM lives l, songs s, members_songs ms
			WHERE l.id = s.live_id  AND s.id = ms.song_id
			AND (ms.sub_instrument IS NULL OR ms.sub_instrument = "")
			%s
			GROUP BY inst
			UNION
			SELECT CONCAT(ms.instrument, "&", ms.sub_instrument) inst, COUNT(*) sum
			FROM lives l, songs s, members_songs ms
			WHERE l.id = s.live_id AND s.id = ms.song_id
			AND ms.sub_instrument IS NOT NULL AND ms.sub_instrument != ""
			%s
			GROUP BY inst
			ORDER BY sum DESC',
			$condition, $condition
		));
		$this->set('inst_rank', $inst_rank);

	}

	public function member() {

		$year = isset($this->request->query['year']) ? $this->request->query['year'] : $this->Auth->user('year');

		// 出演数ランキング
		$mem_rank = $this->Member->query(sprintf(
			'SELECT m.id, CONCAT(m.last_name, " ", m.first_name) name, m.nickname, COUNT(*) sum
			FROM lives l, members m, songs s, members_songs ms
			WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
			AND m.year = "%s"
			GROUP BY m.id
			ORDER BY COUNT(*) DESC
			LIMIT 20',
			$year
		));
		$this->set('mem_rank', $mem_rank);

		// アーティストランキング
		$art_rank = $this->Song->query(sprintf(
			'SELECT s.artist name, COUNT(*) sum
			FROM lives l, songs s, members m, members_songs ms
			WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
			AND m.year = "%s"
			GROUP BY s.artist
			ORDER BY COUNT(*) DESC
			LIMIT 20',
			$year
		));
		$this->set('art_rank', $art_rank);

		// 楽器ランキング
		$inst_rank = $this->MembersSong->query(sprintf(
			'SELECT ms.instrument inst, COUNT(*) sum
			FROM lives l, members m, songs s, members_songs ms
			WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
			AND (ms.sub_instrument IS NULL OR ms.sub_instrument = "")
			AND m.year = "%s"
			GROUP BY inst
			UNION
			SELECT CONCAT(ms.instrument, "&", ms.sub_instrument) inst, COUNT(*) sum
			FROM lives l, members m, songs s, members_songs ms
			WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
			AND ms.sub_instrument IS NOT NULL AND ms.sub_instrument != ""
			AND m.year = "%s"
			GROUP BY inst
			ORDER BY sum DESC',
			$year, $year
		));
		$this->set('inst_rank', $inst_rank);

	}

}
