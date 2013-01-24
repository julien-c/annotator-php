<?php

use Symfony\Component\HttpFoundation\Request;

require_once __DIR__.'/vendor/autoload.php';

$app = new Silex\Application();

/***
 *
 * Accepting JSON in request body.
 * @note: the method described in http://silex.sensiolabs.org/doc/cookbook/json_request_body.html doesn't allow us to get the whole parameter array.
 *
 */

$app->before(function (Request $request) use ($app) {
	if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
		$app['data'] = json_decode($request->getContent(), true);
	}
});


/***
 *
 * Endpoints.
 * @see https://github.com/okfn/annotator/wiki/Storage
 *
 */


$app->get('/', function () use ($app) {
	$out = array(
		'name'    => "Annotator Store API (PHP)",
		'version' => '1.0.0',
		'author'  => 'julien-c'
	);
	return $app->json($out);
});


$app->get('/annotations', function () use ($app) {
	$out = array();
	
	$m = new Mongo();
	$c = $m->annotator->annotations->find();
	
	foreach($c as $post) {
		$post['id'] = (string) $post['_id'];
		unset($post['_id']);
		$out[] = $post;
	}
	
	return $app->json($out);
});


$app->post('/annotations', function () use ($app) {
	$post = $app['data'];
	
	$m = new Mongo();
	$m->annotator->annotations->insert($post, array('safe' => true));
	
	$post['id'] = (string) $post['_id'];
	unset($post['_id']);
	
	return $app->json($post);
});


/***
 *
 * Run, App, Run!
 *
 */

$app['debug'] = true;
$app->run();