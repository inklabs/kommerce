<?php

class Controller_Admin_System extends Controller_Admin_Template {
	public $enabled_formats = array('txt', 'json');

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
