<?php


require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();


$app->get('/annotations', function () use ($app) {
	$out = array();
	return $app->json($out);
});


/***
 *
 * Run, App, Run!
 *
 */

$app['debug'] = true;
$app->run();