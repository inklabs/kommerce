<?php

abstract class Session extends Kohana_Session {

	public static function has_started() {
		return isset($_COOKIE['session']);
	}
}
