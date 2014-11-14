<?php
class StatisticsController extends AppController {

	public $uses = array('Live', 'Member', 'Song', 'MembersSong');

	public function index() {

		if (isset($this->request->query['year'])) {
			$year = $this->request->query['year'];
		} else {
			$now = getdate();
			$year = $now['mon'] > 3 ? $now['year'] : $now['year'] - 1;
		}
		$condition = $year === 'all' ? '' : sprintf('AND l.date BETWEEN "%s-04-01" AND "%s-03-31"', $year, (int)($year) + 1);

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
			ORDER BY sum DESC
			LIMIT 20',
			$condition
		));
		$this->set('mem_rank', $mem_rank);

		// アーティストランキング
		$art_rank = $this->Song->query(sprintf(
			'SELECT s.artist name, COUNT(*) sum
			FROM lives l, songs s
			WHERE l.id = s.live_id
			AND s.artist != ""
			%s
			GROUP BY s.artist
			ORDER BY sum DESC
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
			$song_sum, $condition
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
			'SELECT inst, COUNT(*) sum
			FROM (
				SELECT ms.instrument inst
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id  AND s.id = ms.song_id
				%s
				UNION ALL
				SELECT ms.sub_instrument inst
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id  AND s.id = ms.song_id
				AND ms.sub_instrument IS NOT NULL AND ms.sub_instrument != ""
				%s
			) i
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
			AND s.artist != ""
			AND m.year = "%s"
			GROUP BY s.artist
			ORDER BY COUNT(*) DESC
			LIMIT 20',
			$year
		));
		$this->set('art_rank', $art_rank);

		// 楽器ランキング
		$inst_rank = $this->MembersSong->query(sprintf(
			'SELECT inst, COUNT(*) sum
			FROM (
				SELECT ms.instrument inst
				FROM lives l, songs s, members m, members_songs ms
				WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
				AND m.year = "%s"
				UNION ALL
				SELECT ms.sub_instrument inst
				FROM lives l, songs s, members m, members_songs ms
				WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
				AND ms.sub_instrument IS NOT NULL AND ms.sub_instrument != ""
				AND m.year = "%s"
			) i
			GROUP BY inst
			ORDER BY sum DESC',
			$year, $year
		));
		$this->set('inst_rank', $inst_rank);

	}

	public function me() {

		$mid = isset($this->request->query['mid']) ? $this->request->query['mid'] : $this->Auth->user('id');
		$year = isset($this->request->query['year']) ? $this->request->query['year'] : 'all';
		$condition = $year === 'all' ? '' : sprintf('AND l.date BETWEEN "%s-04-01" AND "%s-03-31"', $year, (int)($year) + 1);

		// 出演数
		$song_sum = $this->Song->query(sprintf(
			'SELECT COUNT(*) count
			FROM lives l, songs s, members_songs ms
			WHERE l.id = s.live_id AND s.id = ms.song_id
			AND ms.member_id = %d
			%s',
			$mid, $condition
		));
		$this->set('song_sum', $song_sum[0][0]['count']);

		// 共演数
		$mem_rank = $this->MembersSong->query(sprintf(
			'SELECT m.id, CONCAT(m.last_name, " ", m.first_name) name, m.nickname, COUNT(*) sum
			FROM lives l, songs s, members m, members_songs ms
			WHERE l.id = s.live_id AND m.id = ms.member_id AND s.id = ms.song_id
			AND ms.song_id IN (
				SELECT ms.song_id
				FROM members_songs ms
				WHERE ms.member_id = %d
				%s
			)
			AND ms.member_id != %d
			GROUP BY ms.member_id
			ORDER BY sum DESC, m.year DESC, m.furigana',
			$mid, $condition, $mid
		));
		$this->set('mem_rank', $mem_rank);

		// アーティストランキング
		$art_rank = $this->Song->query(sprintf(
			'SELECT s.artist name, COUNT(*) sum
			FROM lives l, songs s, members_songs ms
			WHERE l.id = s.live_id AND s.id = ms.song_id
			AND s.artist != ""
			AND ms.member_id = %d
			%s
			GROUP BY s.artist
			ORDER BY sum DESC, name',
			$mid, $condition
		));
		$this->set('art_rank', $art_rank);

		// 構成人数
		$band_num = $this->MembersSong->query(sprintf(
			'SELECT band.num, ROUND(COUNT(*) / %d * 100, 1) AS percent
			FROM (
				SELECT COUNT(*) num
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id AND s.id = ms.song_id
				AND ms.song_id IN (
					SELECT ms.song_id
					FROM members_songs ms
					WHERE ms.member_id = %d
					%s
				)
				GROUP BY ms.song_id
			) band
			GROUP BY band.num',
			$song_sum[0][0]['count'], $mid, $condition
		));
		$band_avg_std = $this->MembersSong->query(sprintf(
			'SELECT AVG(band.num) avg, STD(band.num) std
			FROM (
				SELECT ms.song_id, COUNT(*) num
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id AND s.id = ms.song_id
				AND ms.song_id IN (
					SELECT ms.song_id
					FROM members_songs ms
					WHERE ms.member_id = %d
					%s
				)
				GROUP BY ms.song_id
			) band',
			$mid, $condition
		));
		$this->set('band_num', $band_num);
		$this->set('band_avg_std', $band_avg_std);

		// 楽器ランキング
		$inst_rank = $this->MembersSong->query(sprintf(
			'SELECT inst, COUNT(*) sum
			FROM (
				SELECT ms.instrument inst
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id  AND s.id = ms.song_id
				AND ms.member_id = %d
				%s
				UNION ALL
				SELECT ms.sub_instrument inst
				FROM lives l, songs s, members_songs ms
				WHERE l.id = s.live_id  AND s.id = ms.song_id
				AND ms.sub_instrument IS NOT NULL AND ms.sub_instrument != ""
				AND ms.member_id = %d
				%s
			) i
			GROUP BY inst
			ORDER BY sum DESC',
			$mid, $condition, $mid, $condition
		));
		$this->set('inst_rank', $inst_rank);

	}

}
