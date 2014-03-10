<?php
$I = new WebGuy($scenario);
$I->wantTo('ensure countries are blocked: china, russia, and india');

// Localhost
$I->sendGET('/page/available');
$I->seeResponseCodeIs(200);

// US
$I->haveHttpHeader('X-Forwarded-For', '24.24.24.24');
$I->sendGET('/page/available');
$I->seeResponseCodeIs(200);

// Indonesia
$I->haveHttpHeader('X-Forwarded-For', '27.50.16.0');
$I->sendGET('/page/available');
$I->seeResponseCodeIs(403);

// China
$I->haveHttpHeader('X-Forwarded-For', '58.14.0.0');
$I->sendGET('/page/available');
$I->seeResponseCodeIs(403);

// Russia
$I->haveHttpHeader('X-Forwarded-For', '2.60.0.0');
$I->sendGET('/page/available');
$I->seeResponseCodeIs(403);

// India
$I->haveHttpHeader('X-Forwarded-For', '1.6.0.0');
$I->sendGET('/page/available');
$I->seeResponseCodeIs(403);
