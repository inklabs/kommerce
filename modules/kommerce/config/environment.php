<?php

return [
	'enable' => [
		'x-forwarded-for' => TRUE,
	],

	'mock_ip_address' => '24.24.24.24',

	'allowed_countries' => [
		// 'US',
		// 'CA',
	],

	'denied_countries' => [
		'CN',
		'RU',
		'IN',
		'ID',
	],
];
