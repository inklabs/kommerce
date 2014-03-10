<?php

/**
 * http://dev.maxmind.com/geoip/geoip2/geolite2/
 *
 * Example:
 *
 * ./minion --task=Maxmind:GeoLite2
 *
 * Also get City:
 * ./minion --task=Maxmind:GeoLite2 --city=1
 *
 */
class Task_Maxmind_GeoLite2 extends Minion_Task
{
	protected $_options = array(
		'city' => 0,
		'country' => 1,
	);

	protected $curl_connect_timeout_ms = 1000; // milliseconds
	protected $curl_dl_timeout = 11;           // seconds

	protected $base_url = 'http://geolite.maxmind.com/download/geoip/database/';
	protected $city_file = 'GeoLite2-City';
	protected $country_file = 'GeoLite2-Country';

	protected function _execute(array $params)
	{
		$city = (int) Arr::get($params, 'city');
		$country = (int) Arr::get($params, 'country');

		if ($country === 1) {
			$this->get_file($this->country_file);
		}

		if ($city === 1) {
			$this->get_file($this->city_file);
		}
	}

	protected function get_file($file) {
		list($db_filename, $db_timestamp) = $this->_download($this->base_url . $file . '.mmdb.gz', $file);
		$valid_md5 = $this->_download_output($this->base_url . $file . '.md5');

		$db_filename = $this->gunzip($db_filename);

		$check_md5 = md5_file($db_filename);

		if ($valid_md5 === $check_md5) {
			$new_filename = APPPATH . '/data/maxmind/' . $file . '.mmdb';
			rename($db_filename, $new_filename);
			touch($new_filename, $db_timestamp);
		} else {
			unlink($db_filename);
			throw new Exception('Checksum does not match for ' . $file);
		}
	}

	protected function gunzip($filename) {
		$fp = gzopen($filename, 'rb');

		$temp_filename = tempnam('/tmp', 'maxmind_');
		$fp_out = fopen($temp_filename, 'wb');

		while ( ! gzeof($fp)) {
			fwrite($fp_out, gzread($fp, 4096));
		}

		fclose($fp_out);
		gzclose($fp);

		unlink($filename);
		return $temp_filename;
	}

	protected function _download($url, $file_name) {
		$temp_filename = tempnam('/tmp', 'maxmind_');
		$fp = fopen($temp_filename, 'w');

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->curl_connect_timeout_ms);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_dl_timeout);
		curl_setopt($ch, CURLOPT_FILETIME, TRUE);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
		// curl_setopt($ch, CURLOPT_BUFFERSIZE, 64000);
		curl_setopt($ch, CURLOPT_NOPROGRESS, FALSE);
		curl_setopt($ch, CURLOPT_PROGRESSFUNCTION,
			function($resource, $download_size, $downloaded_size, $upload_size, $uploaded) use ($file_name) {
				static $previous_progress = 0;

				if ($download_size == 0) {
					$progress = 0;
				} else {
					$progress = round(($downloaded_size * 100) / $download_size);
				}

				if ($progress > $previous_progress) {
					$previous_progress = $progress;

					echo $file_name , ': ' , str_pad($progress, 3, ' ', STR_PAD_LEFT) , "%\r";
					ob_flush();
				}
			}
		);
		curl_setopt($ch, CURLOPT_FILE, $fp);

		$success = curl_exec($ch);
		$file_timestamp = curl_getinfo($ch, CURLINFO_FILETIME);

		echo "\n";

		curl_close($ch);
		fclose($fp);

		if ( ! $success) {
			unlink($temp_filename);
			throw new Exception('Unable to download from Maxmind (' . $url . ').');
		}

		return [$temp_filename, $file_timestamp];
	}

	protected function _download_output($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $this->curl_connect_timeout_ms);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_dl_timeout);
		$output = curl_exec($ch);
		curl_close($ch);

		return $output;
	}
}
