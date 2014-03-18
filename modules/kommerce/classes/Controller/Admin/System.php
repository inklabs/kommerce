<?php

class Controller_Admin_System extends Controller_Admin_Template {
	public $enabled_formats = array('txt', 'json');

	public function action_redis() {
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		$redis_info = $redis->info();

		$keys = array(
			'PHPREDIS_SESSION:*',
			'CACHE:*',
		);

		$key_counts = [];
		foreach ($keys as $prefix) {
			$key_counts[$prefix] = $redis->eval('return table.getn(redis.call("keys", "' . $prefix . '"))');
		}

		$this->data['key_counts'] = $key_counts;
		$this->data['redis_info'] = $redis_info;
	}

	public function action_redis_clear_all() {
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);

		$redis->flushDB();
		Message::add('success', 'Successfully cleared the entire cache.');

		// Reset find_file() cache.
		Kohana::cache('Kohana::find_file()', NULL, -99999);

		$this->redirect('/admin/system/redis');
	}

	public function action_maxmind() {

		$ip = $this->request->query('ip');
		if ($ip === NULL) {
			$ip = Kommerce::remote_ip(TRUE);
		}

		$this->data['remote_ip'] = $ip;
		// $this->data['country'] = Maxmind::get_country($ip);
		$this->data['city'] = Maxmind::get_city($ip);
	}
}
