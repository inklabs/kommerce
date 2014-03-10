<?php

class Kommerce {
	const NAME = 'Zen Kommerce';
	const SAFE_NAME = 'zen_kommerce';
	const VERSION  = '0.1.1';
	const CODENAME = 'alpha';
	const WEBSITE = 'http://inklabs.github.io/kommerce/';
	const GITHUB = 'https://github.com/inklabs/kommerce';

	/**
	 * Return FALSE if the IP address is a private one, TRUE otherwise.
	 *  10.0.0.0/8
	 *  172.16.0.0/12
	 *  192.168.0.0/16
	 *  169.254.0.0/16
	 *  127.0.0.1
	 *
	 * @param string $ip 
	 * @return bool
	 */
	public static function is_private_ip($ip) { 
		return ! filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
	}

	public static function remote_ip($mock_local = FALSE) {

		$ip = Arr::get($_SERVER, 'REMOTE_ADDR');

		if (TRUE === Kohana::$config->load('environment')->get('enable')['x-forwarded-for']) {
			$ip = Arr::get($_SERVER, 'HTTP_X_FORWARDED_FOR', $ip);
		}

		if ($mock_local AND self::is_private_ip($ip)) {
			$ip = Kohana::$config->load('environment')->get('mock_ip_address');
		}

		return $ip;
	}

	public static function verify_country() {
		$ip_address = self::remote_ip(TRUE);
		$country = Maxmind::get_country($ip_address);
		$iso_3316 = Arr::path($country, 'country.iso_code');

		if (empty($iso_3316)) {
			return;
		}

		$allowed_countries = Kohana::$config->load('environment')->get('allowed_countries');

		if ( ! empty($allowed_countries)) {
			if ( ! in_array($iso_3316, $allowed_countries)) {
				header("HTTP/1.1 403 Forbidden");
				echo '403 Forbidden';
				exit;
			}
 		} else {
			$denied_countries = Kohana::$config->load('environment')->get('denied_countries');

			if ( ! empty($denied_countries)) {
				if (in_array($iso_3316, $denied_countries)) {
					header("HTTP/1.1 403 Forbidden");
					echo '403 Forbidden';
					exit;
				}
			}
		}
	}

	public static function is_prod() {
		return (Kohana::$environment == Kohana::PRODUCTION);
	}

	public static function is_stage() {
		return (Kohana::$environment == Kohana::STAGING);
	}

	public static function is_dev() {
		return (Kohana::$environment == Kohana::DEVELOPMENT);
	}
}
