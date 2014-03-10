<?php
	if (empty($city)) {
		echo 'Unable to locate.';
	} else {
		$iso_3316 = $city['country']['iso_code'];

	// var_export(
	print_r(
		['remote ip'   => $remote_ip] +
		['city'        => Arr::path($city, 'city.names.en')] +
		['postal code' => Arr::path($city, 'postal.code')] +
		['continent'   => Arr::path($city, 'continent.names.en')] +
		['iso-3316'    => $iso_3316] +
		['country'     => Arr::path($city, 'country.names.en')] +
		$city['location']
	);
}
