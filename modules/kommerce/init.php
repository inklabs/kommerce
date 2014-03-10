<?php

Kommerce::verify_country();

Cookie::$salt = 'YOUR-COOKIE-SALT';

Route::set('admin', 'admin(/<controller>(/<action>(/<id>)(.<format>)))', array(
		'format' => '(txt|json)',
	))
	->defaults(array(
		'directory'  => 'Admin',
		'controller' => 'dashboard',
		'action' => 'index',
		'format' => NULL,
	));
