<?php


require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();



$app->get('/', function () use ($app) {
	$out = array(
		'name' => "Annotator Store API (PHP)",
		'version' => '1.0.0',
		'author' => 'julien-c'
	);
	return $app->json($out);
});


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