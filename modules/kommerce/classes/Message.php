<?php defined('SYSPATH') or die('No direct access allowed.');

class Message {

	public static function output() {
		$str = '';
		$messages = Session::instance()->get('messages');
		Session::instance()->delete('messages');
		if ( ! empty($messages)) {
			foreach ($messages as $type => $messages) {
				foreach ($messages as $message) {
					// Fixing for Bootstrap 3 Upgrade
					if ($type == 'error') {
						$type = 'danger';
					}
					$str .= '<div class="alert alert-' . $type . '">' .
						'<button type="button" class="close" data-dismiss="alert">&times;</button>';

					switch ($type) {
						case 'success': $str .= '<i class="glyphicon glyphicon-ok-sign"></i> '; break;
						case 'info':    $str .= '<i class="glyphicon glyphicon-info-sign"></i> '; break;
						case 'warning': $str .= '<i class="glyphicon glyphicon-warning-sign"></i> '; break;
						case 'danger':  $str .= '<i class="glyphicon glyphicon-exclamation-sign"></i> '; break;
						default: break;
					}

					$str .= $message . '</div>';
				}
			}
		}
		return $str;
	}

	public static function add($type, $msg) {
		$messages = Session::instance()->get('messages', array());

		$messages[$type][] = $msg;
		Session::instance()->set('messages', $messages);
	}

	public static function get_codes() {
		$message_codes = Session::instance()->get('message_codes', array());
		Session::instance()->delete('message_codes');
		return $message_codes;
	}

	public static function add_codes($codes) {
		$message_codes = self::get_codes();
		foreach ($codes as $k => $v) {
			$message_codes[$k] = $v;
		}
		Session::instance()->set('message_codes', $message_codes);
	}

	public static function count() {
		return sizeof(Session::instance()->get('messages'));
	}
}
